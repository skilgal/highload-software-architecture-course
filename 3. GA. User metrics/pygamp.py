#!/usr/bin/env python3

import PyGAMP as pg
import requests
import uuid

client_id = str(uuid.uuid4())
ga_tracking_id = "UA-212140947-1"

response = requests.get(
    "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json&valcode=USD"
)
uahUsdRate = response.json()[0]["rate"] * 1000

print("Currency rate is ", int(uahUsdRate))

pg.event(
    cid=client_id,
    property_id=ga_tracking_id,
    category="Currency rate",
    action="update",
    label="uah/usd",
    value=uahUsdRate,
    non_interactive=0,
)


data = {
    "v": "1",  # API Version.
    "tid": ga_tracking_id,  # Tracking ID / Property ID.
    # Anonymous Client Identifier. Ideally, this should be a UUID that
    # is associated with particular user, device, or browser instance.
    "cid": "555",
    "t": "event",  # Event hit type.
    "ec": "Currency rate",  # Event category.
    "ea": "Update",  # Event action.
    "el": "UAH/USD",  # Event label.
    "ev": uahUsdRate,  # Event value, must be an integer
    "ua": "Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14",
}

response = requests.post("https://www.google-analytics.com/collect", data=data)

# If the request fails, this will raise a RequestException. Depending
# on your application's needs, this may be a non-error and can be caught
# by the caller.
response.raise_for_status()
