class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  authenticates_with_sorcery!

  field :first_name, type: String
  field :last_name, type: String
  field :email, type: String
  field :business_type, type: Symbol

  validates_presence_of :email
  validates_presence_of :first_name
  validates_presence_of :last_name
  validates_uniqueness_of :email

  has_many :campaigns
end
