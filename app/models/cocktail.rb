class Cocktail
  include Mongoid::Document

  field :title, type: String
  field :description, type: String
  field :price, type: Integer

  validates_presence_of :title
  validates_uniqueness_of :title
  validates_presence_of :price

  has_many :campaigns
  has_many :goals
end
