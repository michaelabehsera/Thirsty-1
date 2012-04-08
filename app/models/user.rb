class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  include Gravtastic
  authenticates_with_sorcery!
  is_gravtastic
  gravtastic size: 35

  before_create :preset_background

  field :name, type: String
  field :username, type: String
  field :email, type: String
  field :type, type: Symbol
  field :bio, type: String
  field :profile, type: String
  field :tags, type: String
  field :title, type: String
  field :admin, type: Boolean, default: false
  field :preset_image, type: String
  field :timestamp, type: Integer

  mount_uploader :avatar, AvatarUploader
  mount_uploader :background, BackgroundUploader

  validates_presence_of :email
  validates_uniqueness_of :email
  validates_uniqueness_of :username

  has_many :helps
  has_many :headlines
  has_many :chats
  has_many :socials
  has_many :campaigns
  has_and_belongs_to_many :active_campaigns, class_name: 'Campaign', inverse_of: :marketers
  has_many :comments
  has_many :articles
  has_many :bits

  def preset_background
    rsp = HTTParty.get 'http://colourlovers.com/api/patterns/top'
    self.preset_image = rsp['patterns']['pattern'].shuffle.first['imageUrl']
  end

  def self.subscribe
    Juggernaut.subscribe do |event, data|
      if data['meta']
        begin
          user = User.find(data['meta']['user_id'])
          campaign = Campaign.find(data['meta']['campaign_id'])
          case event
            when :subscribe
              campaign.subscriptions << user
              Juggernaut.publish campaign.uuid, { user_id: user.id, username: user.username, name: user.name, event_type: 'subscribe' }
            when :unsubscribe
              campaign.subscriptions.delete user
              Juggernaut.publish campaign.uuid, { user_id: user.id, event_type: 'unsubscribe' }
          end
        rescue
        end
      end
    end
  end
end
