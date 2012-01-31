class CampaignsController < ApplicationController

  expose(:campaign) { Campaign.where(uuid: params[:uuid]).first }

  def create
    campaign = Campaign.new(uuid: UUID.new.generate)
    campaign.user = current_user
    domain = params[:domain].gsub('-', '.')
    Stalker.enqueue('campaign.load', { id: campaign.id, domain: domain }, ttr: 9999)
    if campaign.save
      redirect_to "/campaigns/#{campaign.uuid}"
    else
      render inline: 'fail'
    end
  end

  def index
  end

end
