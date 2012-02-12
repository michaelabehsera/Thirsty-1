class Plugin
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :filename, type: String
  field :foldername, type: String
  field :title, type: String
  field :description, type: String
end
