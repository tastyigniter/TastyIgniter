package com.minorguys.tastyigniter;

import android.util.Log;
import android.util.Pair;
import android.widget.Toast;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;

/**
 * Created by arpit on 2/10/17.
 */

public class Cart  {


    static HashMap<String , Integer> samaan=new HashMap<>();
    public static int getA(String x)
    {
        try{
            int xx=samaan.get(x);
            return samaan.get(x);
        }
        catch(Exception e){
            return 0;
        }

    }
    public static void setIDA(String x, Integer y)
    {
        samaan.put(x,y);
    }
    public static void adder(String x) {
        samaan.put(x, getA(x) + 1);
    }
    public static void sub(String x) {
        samaan.put(x, getA(x) - 1);
    }
}
