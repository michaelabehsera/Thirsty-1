class Page
  include Mongoid::Document

  field :url, type: String
  field :title, type: String

  belongs_to :campaign
end
