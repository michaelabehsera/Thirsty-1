class Article
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  before_create :add_month, :parse_content

  field :title, type: String
  field :content, type: String
  field :bio, type: String
  field :url, type: String
  field :unique_pageviews, type: Integer, default: 0
  field :month, type: Integer
  field :approved, type: Boolean

  has_one :notification
  belongs_to :user
  belongs_to :campaign

  def add_month
    self.month = self.campaign.month
  end

  def parse_content
    self.content = self.content.gsub('<b>', '<strong>').gsub('<i>', '<em>')
  end
end
