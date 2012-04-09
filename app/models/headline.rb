class Headline
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :title, type: String
  field :approved, type: Boolean
  field :public, type: Boolean, default: false
  field :claimed, type: Boolean, default: false

  belongs_to :campaign
  belongs_to :user
end
