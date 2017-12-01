package com.minorguys.tastyigniter;

import java.security.SecureRandom;

/**
 * Created by arpit on 24/11/17.
 */

public class Order {
   int id;
    Order()
    {
        //id=(int)(Math.random()*100000);
        SecureRandom s=new SecureRandom();
        int n=s.nextInt(100000);
        String S=String.format("%05d",n);
        id=Integer.parseInt(S);
    }

}
