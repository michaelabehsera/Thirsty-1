module Wordpress
  # A proof of concept class, displaying how to manage a WP blog through ruby
  class Blog
    attr_accessor :agent, :blog_uri, :username, :password, :logged_in
    def initialize blog_uri, username, password
      @username = username
      @password = password
      @blog_uri = blog_uri.gsub(/\/$/,"") # remove last slash if given
      @agent = Mechanize.new
      @current_page = @agent.get(blog_uri) # Will throw errors if page does not exist, or if blog_uri is invalid
      @logged_in = false
    end
    def logged_in?; @logged_in; end
    def enable_remote_blogging
      login!
      page = agent.page.link_with(:text => 'Writing').click
      form = page.forms.first
      form.checkbox_with(:name => 'enable_app').check
      page = agent.submit(form, form.buttons.first)
    end
    def login!
      unless logged_in?
        page = agent.get(login_uri)
        form = page.form('loginform')
        form.log = username
        form.pwd = password
        agent.submit(form, form.buttons.first)
        logged_in = true
      end
    end
    def login_uri; "#{blog_uri}/wp-login.php"; end
    def post_collection_uri; "#{blog_uri}/wp-app.php/posts"; end
    def service_uri; "#{blog_uri}/wp-app.php/service"; end
    def publish_post post
      raise "Post cannot be nil" if post == nil
      raise "You can only publish valid Atom::Entry items" unless post.class == Atom::Entry
      Atom::Pub::Collection.new(:href => post_collection_uri).publish(post, :user => username, :pass => password)
    end
    def add_category opts = {}
      login!
      unless category_exists? opts
        page = agent.get("#{blog_uri}/wp-admin/edit-tags.php?taxonomy=category")
        form = page.form_with(:action => "edit-tags.php")
        form.send(:"tag-name",opts[:term])
        form.slug = opts[:scheme]
        form.description = opts[:description]
        agent.submit(form, form.buttons.first)
      end
    end
    def category_exists? opts
      exists = false
      uri = URI.parse(blog_uri + '/wp-app.php/categories')
      content = Net::HTTP.start(uri.host) do |http|
        req = Net::HTTP::Get.new(uri.path)
        req.basic_auth username, password
        response = http.request(req)
        response.body
      end
      doc = Nokogiri::XML(content)
      doc.search("category").each do |cat|
        exists = true if cat.attr("term") == opts[:term]
      end
      exists
    end
  end
end
