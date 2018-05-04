# mqtt-bridge
mqtt bridge for PHP

In cases you have devices or applications that cannot directly talk to MQTT message brokers you can enable them by using this simple bridge. All what is required is the capability to do HTTP, better HTTPS requests.

## Installation

Copy to the web root of your favored web server. Copy the config.sample.php to config.php and adapt the values accordingly. Then use it as follows:

* http(s)://{server}:{port}/mqtt-bridge/?topic={topic}&value={value}&retain={0|1}[&user={user}&pass={password}]

Instead of passing user and password in GET request you can also pass it by POST when you are for more security and your client is capable of it. HTTPS, nevertheless, is highly recommended.
