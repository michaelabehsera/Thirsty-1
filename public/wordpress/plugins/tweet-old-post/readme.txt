=== Tweet Old Post ===
Contributors: Ajay Matharu
Tags: Tweet old post, Tweets, Promote old post by tweeting about them, Twitter, Auto Tweet, Hashtags, Twitter Hashtags, Tweet Posts, Tweet, Post Tweets, Wordpress Twitter Plugin, Twitter Plugin, Tweet Selected Posts
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: trunk

Plugin to tweet about your old posts to get more hits for them and keep them alive.

== Description ==

Tweet Old Posts is a plugin designed to tweet your older posts to get more traffic. 

Tweet Old Posts randomly picks your older post based on the interval specified by you. The primary function of this plugin is to promote older blog posts by tweeting about them and getting more traffic.

For updates follow http://twitter.com/matharuajay

**Fortcoming**

- Sleep time
- Post priority
- Additional text based on categories
- Post for Facebook and Google+
- Option to set number of tweets to post at a time


**Pro Version (will be released soon)**
- Change via Tweet Old Post to your specified name
- Multiple Twitter accounts


**Let me know if you have any more ideas**

**New in v3.3.1**

- Changed logic for posting data to twitter.
- Resolved bit.ly issue.


**New in v3.3.0**

- Attempt to fix logs out issue (Tweet Old Post pushes out when any action is performed).


**New in v3.2.9**

- Option to reset setting. When something goes wrong, please reset the settings and setup again.
- For people still facing issues of conflict with Google Analytics Plugin, this version should work.
- Minor bug fixes.


**New in v3.2.8**

- Resolved conflict with Google Analytics Plugin.
- Changed the log file location to root of plugin folder.
- Maintained Tweet Cycle. Repeat only when all post have been tweeted.
- Made other optimizations and resolved some minor bugs.


**New in v3.2.7**

- Added logging for people who cant make it work can enable and check the log, or mail me the log file.
- Brought back the exclude post option.
- Made other optimizations and resolved some minor bugs.
- Check http://www.ajaymatharu.com/tweet-old-post-update-3-2-7/ for more detailed explanation.


**New in v3.2.6**

- removed exclude post due to security threat. Will work on it and bring it up back.


**New in v3.2.5**

- Resolved hashtag not posting issue.
- other bug fixes.


**New in v3.2.4**

- Bug fixes


**New in v3.2.3**

- Bug fixes


**New in v3.2.2**

- Resolved bit.ly issue
- new option for hashtags
- other bug fixes


**New in v3.2.1**

- Bug fixes


**New in v3.2**

- Bug fixes
- Option to choose to include link in post
- option to post only title or body or both title and body
- option to set additional text either at beginning or end of tweet
- option to pick hashtags from custom field


**New in v3.1.2**

- Resolved tweets not getting posted when categories are excluded.
- If you are not able to authorise your twitter account set you blog URL in Administration → Settings → General.



**New in v3.1.1**

- Resolved tweets not getting posted issue. Sorry guys :(



**New in v3.1**

- Resolved issue of plugin flooding twitter account with tweets.
- added provision to exclude some post from selected categories



**New in v3.0**

- added OAuth authentication 
- user defined intervals
- may not work under php 4 requires php 5



**New in v2.0**

- added provision to select if you want to shorten the URL or not.
- Cleaned other options.



**New in v1.9**

- Removed PHP 4 support as it was creating problem for lot of people



**New in v1.8**

- Bug Fixes
- Provision to fetch tweet url from custom field



**New in v1.7**

- Removed api option from 1click.at not needed api key



**New in v1.6**

- Made the plugin PHP 4 compatible. Guys try it out and please let me know if that worked.
- Better error prompting. If your tweets are not appearing on twitter. Try "Tweet Now" button you'll see if there is any problem in tweeting.
- Added 1click.at shortning service you need to get the api key from http://theeasyapi.com/ you need to add your machine IP address in the server of http://theeasyapi.com/ for this api key to work.



**New in v1.5**

- Maximum age of post to be eligible for tweet - allows you to set Maximum age of the post to be eligible for tweet
- Added one more shortner service was looking for j.mp but they dont have the api yet.



**New in v1.4**

- Hashtags - allows you to set default hashtags for your tweets



**New in v1.3**

- URL Shortener Service - allows you to select which URL shortener service you want to use.



**New in v1.2**

- Tweet Prefix - Allows you to set prefix to the tweets.
- Add Data - Allows you to add post data to the tweets
- Tweet now - Button that will tweet at that moment without wanting you to wait for scheduled tweet



**v1.1**

- Twitter Username & Password - Using this twitter account credentials plugin will tweet.
- Minimum interval between tweets - allows you to determine how often the plugin will automatically choose and tweet a blog post for you.
- Randomness interval - This is a contributing factor in minimum interval so that posts are randomly chosen and tweeted from your blog.
- Minimum age of post to be eligible for tweet - This allows you to set how old your post should be in order to be eligible for the tweet.
- Categories to omit from tweets - This will protect posts from the selected categories from being tweeted.

== Installation ==

Following are the steps to install the Tweet Old Post plugin

1. Download the latest version of the Tweet Old Posts Plugin to your computer from here.
2. With an FTP program, access your site�s server.
3. Upload (copy) the Plugin file(s) or folder to the /wp-content/plugins folder.
4. In your WordPress Administration Panels, click on Plugins from the menu.
5. You should see Tweet Old Posts Plugin listed. If not, with your FTP program, check the folder to see if it is installed. If it isn�t, upload the file(s) again. If it is, delete the files and upload them again.
6. To turn the Tweet Old Posts Plugin on, click Activate.
7. Check your Administration Panels or WordPress blog to see if the Plugin is working.
8. You can change the plugin options from Tweet Old Posts under settings menu.

Alternatively you can also follow the following steps to install the Tweet Old Post plugin

1. In your WordPress Administration Panels, click on Add New option under Plugins from the menu.
2. Click on upload at the top.
3. Browse the location and select the Tweet Old Post Plugin and click install now.
4. To turn the Tweet Old Posts Plugin on, click Activate.
5. Check your Administration Panels or WordPress blog to see if the Plugin is working.
6. You can change the plugin options from Tweet Old Posts under settings menu.

== Frequently Asked Questions ==

If you have any questions please mail me at,
ajay@ajaymatharu.com or matharuajay@yahoo.co.in

**Tweet Old post does not posts any tweets?**

- If its not tweeting any tweets try playing around with the options. Try setting maxtweetage to none and try again.
- Try removing categories from excluded option. Some of them have posted issues of tweet not getting post when categories are selected in exclued category section.


**Tweet old post giving SimpleXmlElement error?**

- If it is giving SimpleXmlElement error, check with your hosting provider on which version of PHP are they supporting. 
Tweet Old Post supports PHP 5 onwards. It will give SimpleXmlElement error if your hosting provider supports PHP 4
or PHP less than 5


**Tweets not getting posted?**

- If your tweets are not getting posted, try deauthorizing and again authorizing your twitter account with
plugin.


**Plugin flooded your tweeter account with tweets?**

- please check your setting increase the minimum interval between tweets. If your plugin is not updated please update your plugin to latest version.


**Not able to authorize your twitter account with Tweet Old Post**

- If you are not able to authorise your twitter account set you blog URL in Administration → Settings → General.

**Any more questions or doubts?**

- DM me on http://twitter.com/matharuajay or mail me at ajay(at)ajaymatharu(dot)com 


== Screenshots ==

for screenshots you can check out 

http://www.ajaymatharu.com/wordpress-plugin-tweet-old-posts/

== Changelog ==


**New in v3.3.1**

- Changed logic for posting data to twitter.
- Resolved bit.ly issue.


**New in v3.3.0**

- Attempt to fix logs out issue (Tweet Old Post pushes out when any action is performed).


**New in v3.2.9**

- Option to reset setting. When something goes wrong, please reset the settings and setup again.
- For people still facing issues of conflict with Google Analytics Plugin, this version should work.
- Minor bug fixes.



**New in v3.2.8**

- Resolved conflict with Google Analytics Plugin.
- Changed the log file location to root of plugin folder.
- Maintained Tweet Cycle. Repeat only when all post have been tweeted.
- Made other optimizations and resolved some minor bugs.



**New in v3.2.7**

- Added logging for people who cant make it work can enable and check the log, or mail me the log file.
- Brought back the exclude post option.
- Made other optimizations and resolved some minor bugs.
- Check http://www.ajaymatharu.com/tweet-old-post-update-3-2-7/ for more detailed explanation.



**New in v3.2.6**

- removed exclude post due to security threat. Will work on it and bring it up back.



**New in v3.2.5**

- Resolved hashtag not posting issue.
- other bug fixes.



**New in v3.2.4**

- Bug fixes



**New in v3.2.3**

- Bug fixes



**New in v3.2.2**

- Resolved bit.ly issue
- new option for hashtags
- other bug fixes



**New in v3.2.1**

- Bug fixes



**New in v3.2**

- Bug fixes
- Option to choose to include link in post
- option to post only title or body or both title and body
- option to set additional text either at beginning or end of tweet
- option to pick hashtags from custom field



**New in v3.1.2**

- Resolved tweets not getting posted when categories are excluded.
- If you are not able to authorise your twitter account set you blog URL in Administration → Settings → General.



**New in v3.1**

- Resolved issue of plugin flooding twitter account with tweets.
- added provision to exclude some post from selected categories



**New in v3.0**

- added OAuth authentication
- user defined intervals
- may not work under php 4 requires php 5



**New in v2.0**

- added provision to select if you want to shorten the URL or not.
- Cleaned other options.



**New in v1.9**

- Removed PHP 4 support as it was creating problem for lot of people



**New in v1.8**

- Bug Fixes
- Provision to fetch tweet url from custom field



**New in v1.7**

- Removed api option from 1click.at not needed api key



**New in v1.6**

- Made the plugin PHP 4 compatible. Guys try it out and please let me know if that worked.
- Better error prompting. If your tweets are not appearing on twitter. Try "Tweet Now" button you'll see if there is any problem in tweeting.
- Added 1click.at shortning service you need to get the api key from http://theeasyapi.com/ you need to add your machine IP address in the server of http://theeasyapi.com/ for this api key to work.



**New in v1.5**

- Maximum age of post to be eligible for tweet - allows you to set Maximum age of the post to be eligible for tweet
- Added one more shortner service was looking for j.mp but they dont have the api yet.



**New in v1.4**

- Hashtags - allows you to set default hashtags for your tweets



**New in v1.3**

- URL Shortener Service - allows you to select which URL shortener service you want to use.



**New in v1.2**

- Tweet Prefix - Allows you to set prefix to the tweets.
- Add Data - Allows you to add post data to the tweets
- Tweet now - Button that will tweet at that moment without wanting you to wait for scheduled tweet



**v1.1**

- Twitter Username & Password - Using this twitter account credentials plugin will tweet.
- Minimum interval between tweets - allows you to determine how often the plugin will automatically choose and tweet a blog post for you.
- Randomness interval - This is a contributing factor in minimum interval so that posts are randomly chosen and tweeted from your blog.
- Minimum age of post to be eligible for tweet - This allows you to set how old your post should be in order to be eligible for the tweet.
- Categories to omit from tweets - This will protect posts from the selected categories from being tweeted.


== Other Notes ==

Some of the options you can configure for the Tweet Old Posts plugins are,


**New in v3.3.1**

- Changed logic for posting data to twitter.
- Resolved bit.ly issue.


**New in v3.3.0**

- Attempt to fix logs out issue (Tweet Old Post pushes out when any action is performed).


**New in v3.2.9**

- Option to reset setting. When something goes wrong, please reset the settings and setup again.
- For people still facing issues of conflict with Google Analytics Plugin, this version should work.
- Minor bug fixes.


**New in v3.2.8**

- Resolved conflict with Google Analytics Plugin.
- Changed the log file location to root of plugin folder.
- Maintained Tweet Cycle. Repeat only when all post have been tweeted.
- Made other optimizations and resolved some minor bugs.


**New in v3.2.7**

- Added logging for people who cant make it work can enable and check the log, or mail me the log file.
- Brought back the exclude post option.
- Made other optimizations and resolved some minor bugs.
- Check http://www.ajaymatharu.com/tweet-old-post-update-3-2-7/ for more detailed explanation.


**New in v3.2.6**

- removed exclude post due to security threat. Will work on it and bring it up back.


**New in v3.2.5**

- Resolved hashtag not posting issue.
- other bug fixes.


**New in v3.2.4**

- Bug fixes


**New in v3.2.3**

- Bug fixes


**New in v3.2.2**

- Resolved bit.ly issue
- new option for hashtags
- other bug fixes


**New in v3.2.1**

- Bug fixes


**New in v3.2**

- Bug fixes
- Option to choose to include link in post
- option to post only title or body or both title and body
- option to set additional text either at beginning or end of tweet
- option to pick hashtags from custom field


**New in v3.1.2**

- Resolved tweets not getting posted when categories are excluded.
- If you are not able to authorise your twitter account set you blog URL in Administration → Settings → General.


**New in v3.1**

- Resolved issue of plugin flooding twitter account with tweets.
- added provision to exclude some post from selected categories


**New in v3.0**

- added OAuth authentication
- user defined intervals
- may not work under php 4 requires php 5


**New in v2.0**

- added provision to select if you want to shorten the URL or not.
- Cleaned other options.


**New in v1.9**

- Removed PHP 4 support as it was creating problem for lot of people


**New in v1.8**

- Bug Fixes
- Provision to fetch tweet url from custom field


**New in v1.7**

- Removed api option from 1click.at not needed api key


**New in v1.6**

- Made the plugin PHP 4 compatible. Guys try it out and please let me know if that worked.
- Better error prompting. If your tweets are not appearing on twitter. Try "Tweet Now" button you'll see if there is any problem in tweeting.
- Added 1click.at shortning service you need to get the api key from http://theeasyapi.com/ you need to add your machine IP address in the server of http://theeasyapi.com/ for this api key to work.


**New in v1.5**

- Maximum age of post to be eligible for tweet - allows you to set Maximum age of the post to be eligible for tweet
- Added one more shortner service was looking for j.mp but they dont have the api yet.


**New in v1.4**

- Hashtags - allows you to set default hashtags for your tweets


**New in v1.3**

- URL Shortener Service - allows you to select which URL shortener service you want to use.


**New in v1.2**

- Tweet Prefix - Allows you to set prefix to the tweets.
- Add Data - Allows you to add post data to the tweets
- Tweet now - Button that will tweet at that moment without wanting you to wait for scheduled tweet


**v1.1**

- Twitter Username & Password - Using this twitter account credentials plugin will tweet.
- Minimum interval between tweets - allows you to determine how often the plugin will automatically choose and tweet a blog post for you.
- Randomness interval - This is a contributing factor in minimum interval so that posts are randomly chosen and tweeted from your blog.
- Minimum age of post to be eligible for tweet - This allows you to set how old your post should be in order to be eligible for the tweet.
- Categories to omit from tweets - This will protect posts from the selected categories from being tweeted.

