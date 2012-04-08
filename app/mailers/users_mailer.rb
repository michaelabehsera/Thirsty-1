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
