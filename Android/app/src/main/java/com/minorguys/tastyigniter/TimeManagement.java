package com.minorguys.tastyigniter;

import java.util.Date;

/**
 * Created by amazingshuttler on 1/12/17.
 */

public class TimeManagement {
    static boolean orderPlaced=false;
    static Date timeOfOrdering;

    public static Date getTimeOfOrdering() {
        return timeOfOrdering;
    }

    public static void setTimeOfOrdering(Date timeOfOrdering) {
        TimeManagement.timeOfOrdering = timeOfOrdering;
    }

    public static boolean isOrderPlaced() {
        return orderPlaced;
    }

    public static void setOrderPlaced(boolean orderPlaced) {
        TimeManagement.orderPlaced = orderPlaced;
    }
}
