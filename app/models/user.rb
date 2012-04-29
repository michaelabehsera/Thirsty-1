class User
  include Mongoid::Document
  include Sorcery::Model
  include Sorcery::Model::Adapters::Mongoid
  include Gravtastic
  authenticates_with_sorcery!
  is_gravtastic
  gravtastic size: 35

  before_create :preset_background
  after_create :send_notification

  def send_notification
    UsersMailer.new_account(self).deliver
    UsersMailer.welcome(self).deliver
  end

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

end
