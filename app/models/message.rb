class Message
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :content, type: String

  belongs_to :edit
  belongs_to :user, inverse_of: nil
end
