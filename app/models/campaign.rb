class Campaign
  include Mongoid::Document
  field :uuid, type: String
  index :uuid, unique: true

  field :loading, type: Boolean, default: true

  field :title, type: String
  field :notes, type: String
  field :url, type: String

  belongs_to :user
  belongs_to :cocktail
  has_many :pages
  has_many :comments
end
