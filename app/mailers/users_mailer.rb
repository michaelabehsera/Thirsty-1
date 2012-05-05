class UsersMailer < ActionMailer::Base
  default from: 'thirsty-bot@thirsty.com', content_type: 'text/html'

  def new_account(user)
    @user = user
    mail to: 'mike@thirsty.com', subject: 'New Thirsty Account!'
  end

  def welcome(user)
    @user = user
    mail to: user.email, subject: 'Welcome!', postmark_attachments: [File.open("#{Rails.root}/public/guidelines.pdf")]
  end

  def response(uuid, receiver, subject, body)
    @body = body
    edit = Edit.where(uuid: uuid).first
    if receiver == 'f'
      mail from: "thirsty-bot+#{uuid}|t@thirsty.com", to: edit.to.email, subject: subject
    else
      mail from: "thirsty-bot+#{uuid}|f@thirsty.com", to: edit.from.email, subject: subject
    end
  end

  def traffic_update(campaign, clicks)
    @clicks = clicks; @campaign = campaign
    mail to: campaign.user.email, subject: "#{clicks} clicks for #{campaign.title}!"
  end

  def edit(article)
    @article = article
    mail to: article.campaign.user.email, subject: "An article has received updates"
  end

  def headline(headline)
    @headline = headline
    mail to: headline.campaign.user.email, subject: "A new headline has been suggested"
  end

  def public_headline(headline, email)
    @headline = headline
    mail to: email, subject: "A new headline has been suggested"
  end

end
