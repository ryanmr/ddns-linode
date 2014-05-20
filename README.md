Dynamic DNS for Linode
======================

Dynamic DNS kind of sucks at home, but setting DNS dynamically with your Linode is awesome.

Linode provides the API, so let's use it.

## Installation

### Step 1
Configure the settings in `datastore/dd_config.json`:
* Linode API key
* Your own personal key
* Hostnames to listen on

Here is an example of `datastore/dd_config.json`:
```
{
  "api_key": "c2dtWpcPKkOwifKyFV93X1w729@fwGhHSkSFfDsFgmZf1yqnMmB", 
  "token": "kOiwrXNiKdkD",
  "hosts": {
    "fennekin": {"domain_id": "7422875", "resource_id": "5404200"}
  }
}
```
The hostname must match the hostname of the computer that will be *pinging* this script on your Linode. This example assumes a computer at home (which will be pinging the server periodically) is named *fennekin*.

### Step 2
Set your `RewriteBase` path in the `.htaccess` file.

### Step 3
After the server script is setup (on the Linode), configure your clients.

To do so: 

1. Copy the `sample.dynamic-dns.sh` to some location on your client
2. Replace the *DOMAIN* and *PATH* markers to mimic your server installation
3. Replace the *TOKEN* marker with your chosen personal token
4. Run the script to test it out; it will probably require a `chmod +x` to work correctly

You should notice a log file created in your home directory, likely called `.dynamic-dns-result.log`.

You will also want to add this script to your *crontab* so that it will run periodically.

### Step 4
Make sure you intially created a domain or subdomain in your Linode DNS Manager.