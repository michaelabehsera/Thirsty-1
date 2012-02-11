class Tool
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :url, type: String
  field :desc, type: String
  belongs_to :campaign
end
