class Article
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  before_create :add_month, :parse_content
  before_save :bitly

  field :title, type: String
  field :content, type: String
  field :bio, type: String
  field :url, type: String
  field :unique_pageviews, type: Integer, default: 0
  field :month, type: Integer
  field :approved, type: Boolean
  field :tags, type: String

  has_many :bits
  has_one :notification
  belongs_to :user
  belongs_to :campaign

  def bitly
    if self.approved
      self.campaign.marketers.each do |user|
        unless user.bits.where(article_id: self.id).first
          bitly = BitLy.shorten("#{self.url}##{user.id}")
          bit = self.bits.new(url: bitly.short_url, hash: bitly.user_hash)
          bit.user = user
          bit.save
        end
      end
    end
  end

  def add_month
    self.month = self.campaign.month
  end

  def parse_content
    self.content = self.content.gsub('<b>', '<strong>').gsub('<i>', '<em>')
  end
end
