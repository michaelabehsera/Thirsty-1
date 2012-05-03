class Campaign
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  before_create :time_setup

  field :uuid, type: String
  index :uuid, unique: true

  field :paid, type: Boolean, default: false
  field :status, type: Boolean, default: true
  field :num_articles, type: Integer
  field :num_traffic, type: Integer
  field :price, type: Integer

  field :title, type: String
  field :notes, type: String
  field :url, type: String
  field :analytics_id, type: String
  field :guidelines, type: String
  field :stripe_id, type: String

  field :month, type: Integer, default: 0
  field :start_day, type: Integer
  field :end_date, type: Date

  field :ftp_domain, type: String
  field :ftp_user, type: String
  field :ftp_pass, type: String
  field :root_dir, type: String

  field :username, type: String
  field :pass, type: String

  mount_uploader :image, CampaignImage

  belongs_to :user
  has_one :notification
  has_and_belongs_to_many :marketers, class_name: 'User', inverse_of: :active_campaigns
  has_and_belongs_to_many :tags
  has_many :helps
  has_many :headlines
  has_many :chats
  has_many :goals
  has_many :pages
  has_many :comments
  has_many :articles
  has_many :tools
  has_and_belongs_to_many :subscriptions, class_name: 'User', inverse_of: nil

  def time_setup
    self.start_day = Time.now.day
    advance_month
  end

  def advance_month
    self.month = self.month + 1
    self.end_date = Time.now + 1.month
  end

  def check
    Campaign.check(self.url, self.username, self.pass)
  end

  def self.check(url, user, pass)
    url.gsub!('http://', '')
    host = url.split('/')[0]
    if url.split('/').count > 1
      path = '/' + url.split('/')[1..-1].join('/') + '/xmlrpc.php'
    else
      path = '/xmlrpc.php'
    end
    begin
      connection = XMLRPC::Client.new(host, path)
      connection.call('wp.getUsersBlogs', user, pass)
    rescue Exception => e
      return false
    end
    return true
  end

end
