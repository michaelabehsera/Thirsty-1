class Campaign
  include Mongoid::Document

  before_save :parse_url
  before_create :time_setup

  field :uuid, type: String
  index :uuid, unique: true

  field :title, type: String
  field :notes, type: String
  field :url, type: String
  field :analytics_id, type: String
  field :image, type: String

  field :month, type: Integer, default: 0
  field :start_day, type: Integer
  field :end_date, type: Date

  field :username, type: String
  field :pass, type: String

  belongs_to :user
  belongs_to :cocktail
  has_one :notification
  has_and_belongs_to_many :marketers, class_name: 'User', inverse_of: :active_campaigns
  has_many :pages
  has_many :comments
  has_many :articles
  has_many :tools
  has_and_belongs_to_many :subscriptions, class_name: 'User', inverse_of: nil

  def parse_url
    self.url = 'http://' + self.url if self.url[0..6] != 'http://'
  end

  def time_setup
    self.start_day = Time.now.day
    advance_month
  end

  def advance_month
    self.month = self.month + 1
    self.end_date = Time.now + 1.month
  end
end
