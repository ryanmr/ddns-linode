Dynamic DNS for Linode
======================

Dynamic DNS kind of sucks at home, but setting DNS dynamically with your Linode is awesome.

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
The hostname must match the hostname of the computer that will be *pinging* this script on your Linode.

### Step 2
Set your `RewriteBase` path in the `.htaccess` file.

### Step 3

Coming soon.
(Client side script)