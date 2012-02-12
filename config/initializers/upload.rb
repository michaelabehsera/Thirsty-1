require 'net/ftp'
require 'pry'

def upload(plugin, campaign)
  plugin_path = (Rails.root + 'public/plugins').to_s + '/'
  Archive.read_open_filename(plugin_path + plugin.filename) do |ar|
    Net::FTP.open(campaign.ftp_domain, campaign.ftp_user, campaign.ftp_pass) do |ftp|
      root_dir =
        if campaign.root_dir[-1] == '/'
          campaign.root_dir + 'wp-content/plugins/'
        else
          campaign.root_dir + '/wp-content/plugins/'
        end
      ftp.chdir root_dir
      begin
        ftp.mkdir root_dir + plugin.foldername
      rescue
      end
      while entry = ar.next_header
        if entry.pathname[-1] == '/'
          begin
            ftp.mkdir root_dir + entry.pathname
          rescue
          end
        else
          ftp.putbinaryfile(plugin_path + entry.pathname, remotefile=entry.pathname)
        end
      end
    end
  end
  return true
end
