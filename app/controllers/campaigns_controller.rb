require 'atom/pub'

class CampaignsController < ApplicationController

  before_filter :authorize, except: :submit

  expose(:campaign) { Campaign.where(uuid: params[:uuid]).first }

  def authorize
    redirect_to '/signin' unless logged_in?
  end

  def submit
    user = User.find(params[:id])
    blog = Wordpress::Blog.new("http://blog.thirsty.com","chris bolton","123321")

    post_cat = {:term => "Category", :label => "Category", :scheme => "category"}
    blog.add_category post_cat unless blog.category_exists? post_cat

    post = Atom::Entry.new do |post|
      post.title = "Test Title"
      post.authors << Atom::Person.new(:name => user.first_name + ' ' + user.last_name)
      post.categories << Atom::Category.new(post_cat)
      post.updated = Time.now
      post.content = Atom::Content::Html.new params[:content]
    end

    blog.publish_post post

    render json: { success: true }
  end

  def create
    campaign = Campaign.new(uuid: UUID.new.generate)
    campaign.user = current_user
    campaign.cocktail = Cocktail.find(params[:id])
    domain = params[:domain].gsub('-', '.')
    Stalker.enqueue('campaign.load', { id: campaign.id, domain: domain }, ttr: 9999)
    campaign.title = params[:name]
    campaign.url = params[:url]
    campaign.notes = params[:notes]
    if campaign.save
      redirect_to "/campaigns/#{campaign.uuid}"
    else
      render inline: 'fail'
    end
  end

  def index
  end

end
