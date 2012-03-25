class Left
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  field :type, type: Symbol
end
