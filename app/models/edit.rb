class Edit
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :completed, type: Boolean, default: false
  field :uuid, type: String

  has_many :messages
  belongs_to :from, class_name: 'User', inverse_of: nil
  belongs_to :to, class_name: 'User', inverse_of: nil
  belongs_to :campaign
  belongs_to :article
end
