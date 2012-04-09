class Goal
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  after_update :check_success

  field :num, type: Integer
  field :type, type: Symbol
  field :achieved, type: Boolean, default: false
  field :next_step, type: Integer, default: 50

  validates_uniqueness_of :type, scope: :campaign_id

  belongs_to :campaign
  has_one :notification

  def check_success
    self.create_notification if self.achieved && !self.notification
  end
end
