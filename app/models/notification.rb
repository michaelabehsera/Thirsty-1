class Notification
  include Mongoid::Document
  include Mongoid::Timestamps::Created

  after_create :notify

  belongs_to :comment
  belongs_to :article
  belongs_to :campaign

  def notify
    Stalker.enqueue 'notification.send', id: self.id
  end
end
