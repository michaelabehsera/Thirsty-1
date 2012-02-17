class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  include Gravtastic
  authenticates_with_sorcery!
  is_gravtastic
  gravtastic size: 35

  field :first_name, type: String
  field :last_name, type: String
  field :email, type: String
  field :type, type: Symbol
  field :bio, type: String

  validates_presence_of :email
  validates_presence_of :first_name
  validates_presence_of :last_name
  validates_uniqueness_of :email

  has_many :campaigns
  has_and_belongs_to_many :active_campaigns, class_name: 'Campaign', inverse_of: :marketers
  has_many :comments
  has_many :articles
  has_many :bits

  def name
    self.first_name.to_s + ' ' + self.last_name.to_s
  end

  def self.subscribe
    Juggernaut.subscribe do |event, data|
      user = User.find(data['meta']['user_id'])
      campaign = Campaign.find(data['meta']['campaign_id'])
      case event
        when :subscribe
          campaign.subscriptions << user
          Juggernaut.publish campaign.uuid, { user_id: user.id, username: user.name, event_type: 'subscribe' }
        when :unsubscribe
          campaign.subscriptions.delete user
          Juggernaut.publish campaign.uuid, { user_id: user.id, event_type: 'unsubscribe' }
      end
    end
  end
end
