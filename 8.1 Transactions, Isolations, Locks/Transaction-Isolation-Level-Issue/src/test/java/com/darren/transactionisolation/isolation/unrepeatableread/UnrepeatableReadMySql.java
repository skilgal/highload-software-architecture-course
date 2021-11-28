package com.darren.transactionisolation.isolation.unrepeatableread;

import com.darren.transactionisolation.isolation.Inventory;
import com.darren.transactionisolation.model.IsolationResult;
import com.darren.transactionisolation.model.UnrepeatableReadExpectOccur;

/**
 * Author: changemyminds.
 * Date: 2021/4/28.
 * Description:
 * Reference:
 */
public class UnrepeatableReadMySql extends BaseUnrepeatableRead {
    @Override
    public IsolationResult assertDEFAULT(Inventory actual, UnrepeatableReadExpectOccur expectOccur) {
        return notOccur(actual, expectOccur);
    }

    @Override
    public IsolationResult assertREPEATABLE_READ(Inventory actual, UnrepeatableReadExpectOccur expectOccur) {
        return notOccur(actual, expectOccur);
    }
}