class Campaign
  include Mongoid::Document
  field :uuid, type: String
  index :uuid, unique: true

  field :loading, type: Boolean, default: true

  belongs_to :user
  belongs_to :cocktail
  has_many :pages
end
