require 'net/ftp'
require 'pry'

def upload(resource, campaign)
  path = (Rails.root + 'public/wordpress' + (resource.is_a?(Plugin) && 'plugins' || 'themes')).to_s + '/'
  Archive.read_open_filename(path + resource.filename) do |ar|
    Net::FTP.open(campaign.ftp_domain, campaign.ftp_user, campaign.ftp_pass) do |ftp|
      root_dir = campaign.root_dir
      root_dir += '/' if campaign.root_dir[-1] != '/'
      root_dir += 'wp-content'
      root_dir += (resource.is_a?(Plugin) && '/plugins/' || '/themes/')
      ftp.chdir root_dir
      begin
        ftp.mkdir root_dir + resource.foldername
      rescue
      end
      while entry = ar.next_header
        if entry.pathname[-1] == '/'
          begin
            ftp.mkdir root_dir + entry.pathname
          rescue
          end
        else
          ftp.putbinaryfile(path + entry.pathname, remotefile=entry.pathname)
        end
      end
    end
  end
  return true
end
