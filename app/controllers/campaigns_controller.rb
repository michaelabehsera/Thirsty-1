class CampaignsController < ApplicationController

  expose(:campaign) { Campaign.where(uuid: params[:uuid]).first }

  def create
    campaign = Campaign.new(uuid: UUID.new.generate)
    campaign.user = current_user
    campaign.cocktail = Cocktail.find(params[:id])
    domain = params[:domain].gsub('-', '.')
    Stalker.enqueue('campaign.load', { id: campaign.id, domain: domain }, ttr: 9999)
    campaign.title = params[:name]
    campaign.url = params[:url]
    campaign.notes = params[:notes]
    if campaign.save
      redirect_to "/campaigns/#{campaign.uuid}"
    else
      render inline: 'fail'
    end
  end

  def index
  end

end
