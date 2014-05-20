Dynamic DNS for Linode
======================

Dynamic DNS kind of sucks at home, but setting DNS dynamically with your Linode is awesome.

Linode provides the API, so let's use it.

## Installation

### Step 1
Configure the settings in `datastore/dd_config.json`:

* Linode API key
* Your own personal key
* Hostnames to listen on, including
 * a Domain ID
 * a Resource ID 

You can find the Linode API key via your [Linode Profile](https://manager.linode.com/profile/api). Your specific *subdomain* IDs are a little more complicated to fetch. You can use the [Domain List API call](https://www.linode.com/api/dns/domain.list) to get the list of your domain records, look for the top-level domain, then use its ID in conjuction with the [Domain Resource API call](https://www.linode.com/api/dns/domain.resource.list). You can formulate both in a simple GET request right in the browser.

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

In the hosts array object, you can additionally define `updatable`; setting that to false will disable Linode DNS updates for that specific host, but the script will still keep a record of it.

### Step 2
Copy `sample.htaccess` to `.htaccess`, and set your `RewriteBase` path in the `.htaccess` file.

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
Make sure you initially created a domain or subdomain in your Linode DNS Manager.

## Usage

Assuming everything works, the subdomain of your choice (determined by your Domain and Resource IDs), and you have set your cronjob to run occasionally, your subdomain should eventually point to the external IP where a host was pinging the Linode from.

You can also view some information. Browse to `~root/view-hostname` where *~root* is the location of your installation, and *hostname* is the name you would like to view. This will display a nice clickable link.