=== ChatPress ===
Contributors: brothman01
Tags: chatroom, ajax, livechat, live, support
Requires at least: 4.2
Tested up to: 6.1
Requires PHP: 8.0
Stable tag: 2.0.0
License: GPL

A simple WordPress plugin to easily add livechat to your site so that your users can communicate with eachother in real time anonymously.

== Installation ==
This plugin operates using a shortcode, so any page that has a shortcode on it will show
the channel the shortcode is associated with.

To get the Shortcode, either manually type:
[chatpress_channel id="xx"]
where `xx` is the id of the channel post
-- OR --
just look at the list view of every chatpress channel on the dashboard and copy what is in the 'Shortcode' column onto the page of your choice.

== Frequently Asked Questions ==
Can anyone read the chat transcript?
Yes, the chat is readable by anyone, whether they are logged in or not.

Can anyone write in the chat?
No, only logged in users can write into the chat window.

Does the channel refresh automatically?
The chat channel refreshes every 3 seconds automatically getting any new messages, however the viewer of the channel can also refresh the channel manually by clicking the refresh button at the top-right of the chatroom.

Are the senders of messages anonymous?
Yes.

Can images be used in chat messages?
Yes

Changelog:
**1.9.0**
- Added column to show shortcode of every channel
- Fixed function named and do comments
- Updated readme

**1.8.0**
- Submitted plugin to WordPress plugin repository.

**1.7.0:**
- Added timer to AJAX refresh messages every 3 seconds.

**1.6.0**
- Restored SASS support

**1.5.0**
- Removed username from chat message to preserve anonimity of the author.

## Future Features:
* None Planned at this time