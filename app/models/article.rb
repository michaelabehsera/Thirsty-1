class Article
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  before_create :add_month

  field :url, type: String
  field :unique_pageviews, type: Integer, default: 0
  field :month, type: Integer

  has_one :notification
  belongs_to :user
  belongs_to :campaign

  def add_month
    self.month = self.campaign.month
  end
end
