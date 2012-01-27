class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  authenticates_with_sorcery!

  field :email, type: String
end
