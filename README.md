Dynamic DNS for Linode
======================

Dynamic DNS kind of sucks at home, but setting DNS dynamically with your Linode is awesome.

## Installation

### Step 1
Set your Linode API key, your own person key and what hostnames you would like to listen for. Configure these settings in `datastore/dd_config.json`.

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