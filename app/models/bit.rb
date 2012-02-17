class Bit
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :url, type: String
  field :hash, type: String
  field :clicks, type: Integer, default: 0

  validates_uniqueness_of :url, scope: :user_id

  belongs_to :user
  belongs_to :article
end
