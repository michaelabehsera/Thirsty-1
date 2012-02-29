class Theme
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :filename, type: String
  field :foldername, type: String
  field :title, type: String
  field :description, type: String
  field :photo, type: String

  validates_uniqueness_of :filename
end
