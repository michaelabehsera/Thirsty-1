class ApplicationController < ActionController::Base
  protect_from_forgery

  before_filter :auth_from_cookie

  def auth_from_cookie
    auto_login(User.find(cookies[:thirsty_uid])) if cookies[:thirsty_uid].present?
  end

  expose(:notifications) {
    if current_user
      if current_user.type == :marketer
        Campaign.where(paid: true).map{|c|c.notification}.compact
      else
        current_user.campaigns.where(paid: true).map {|campaign| (campaign.cocktail.goals.map {|g|g.notification} + campaign.articles.map {|a|a.notification} + campaign.comments.map {|c|c.notification})}.flatten.compact.sort_by(&:created_at).reverse
      end
    end
  }
end
