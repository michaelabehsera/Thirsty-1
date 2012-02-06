class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  include Gravtastic
  authenticates_with_sorcery!
  is_gravtastic
  gravtastic size: 35

  field :first_name, type: String
  field :last_name, type: String
  field :email, type: String
  field :type, type: Symbol

  validates_presence_of :email
  validates_presence_of :first_name
  validates_presence_of :last_name
  validates_uniqueness_of :email

  has_many :campaigns
  has_many :comments
end
