class Article
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :url, type: String
  field :unique_pageviews, type: Integer, default: 0

  has_one :notification
  belongs_to :user
  belongs_to :campaign
end
