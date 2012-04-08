class UsersMailer < ActionMailer::Base
  default from: 'thirsty-bot@thirsty.com', content_type: 'text/html'

  def response(from, to, email, subject, body)
    @body = body
    mail from: "thirsty-bot+#{to}|#{from}@thirsty.com", to: email, subject: subject
  end

  def traffic_update(campaign, clicks)
    @clicks = clicks; @campaign = campaign
    mail to: campaign.user.email, subject: "#{clicks} clicks for #{campaign.title}!"
  end

end
