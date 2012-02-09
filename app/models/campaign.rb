class Campaign
  include Mongoid::Document

  before_save :parse_url

  field :uuid, type: String
  index :uuid, unique: true

  field :title, type: String
  field :notes, type: String
  field :url, type: String
  field :analytics_id, type: String

  field :username, type: String
  field :pass, type: String

  belongs_to :user
  belongs_to :cocktail
  has_one :notification
  has_many :pages
  has_many :comments
  has_many :articles

  def parse_url
    self.url = 'http://' + self.url if self.url[0..6] != 'http://'
  end
end
