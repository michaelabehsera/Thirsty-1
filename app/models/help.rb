class Help
  include Mongoid::Document

  field :inactive, type: Boolean, default: true

  belongs_to :user
  belongs_to :campaign
end
