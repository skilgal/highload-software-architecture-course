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
