class Headline
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :title, type: String
  field :approved, type: Boolean

  belongs_to :campaign
  belongs_to :user
end
