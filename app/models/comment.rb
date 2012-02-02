class Comment
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :message, type: String

  belongs_to :user
  belongs_to :campaign
end
