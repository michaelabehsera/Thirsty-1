class Social
  include Mongoid::Document

  field :name, type: String
  field :url, type: String

  belongs_to :user

  validates_uniqueness_of :name, scope: :user_id
end
