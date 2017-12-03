package com.minorguys.tastyigniter;

import android.os.Bundle;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.CheckBox;
import android.widget.TextView;

import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;

public class c2 extends AppCompatActivity {
    TextView tv1,tv2;
    CheckBox cb1,cb2,cb3;
    long totalTime =60, runningTime =60;
    Date timeOfActivityStarted;

    public HashMap<String,Integer> itemTime = new HashMap<>();

    public void setItemTime(String itemName, Integer timeOfItem) {
        itemTime.put(itemName,timeOfItem);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if(TimeManagement.isOrderPlaced())
        {
            setContentView(R.layout.activity_c2);

            setItemTime("89",60);
            setItemTime("91",70);
            setItemTime("92",30);
            setItemTime("93",50);
            setItemTime("94",60);
            setItemTime("95",30);
            setItemTime("96",20);
            setItemTime("97",45);
            setItemTime("98",55);
            setItemTime("99",35);
            setItemTime("100",80);
            setItemTime("101",48);
            setItemTime("102",49);
            setItemTime("103",21);
            setItemTime("104",32);
            setItemTime("105",67);
            setItemTime("106",49);
            setItemTime("107",43);
            setItemTime("108",39);
            setItemTime("109",46);
            setItemTime("110",90);
            setItemTime("111",25);
            setItemTime("112",38);
            setItemTime("113",74);
            setItemTime("114",54);
            setItemTime("115",37);
            setItemTime("116",10);
            setItemTime("117",26);
            setItemTime("118",68);
            setItemTime("119",15);
            setItemTime("120",40);
            setItemTime("121",50);
            setItemTime("122",30);
            setItemTime("123",36);
            setItemTime("124",100);
            setItemTime("125",75);
            setItemTime("126",38);
            setItemTime("127",65);
            setItemTime("128",34);
            //setItemTime("120",40);
            tv1 =(TextView)findViewById(R.id.tv1_timer);
            tv2 =(TextView)findViewById(R.id.tv2_timer);
            cb1 =(CheckBox)findViewById(R.id.cb1_timer);
            cb2 =(CheckBox)findViewById(R.id.cb2_timer);
            cb3 =(CheckBox)findViewById(R.id.cb3_timer);

            tv1.setText("ThankYou for Ordering!\n You will receive your meal shortly.");
            cb1.setText("Cooked");
            cb2.setText("Out for Delivery");
            cb3.setText("Shipped");

            int maxTimeOfAllItems=-1;
            for(String item: Cart.samaan.keySet()){
                Log.d("MAMA", "Item to be searched "+item);
                if(maxTimeOfAllItems < itemTime.get(item)){
                    maxTimeOfAllItems = itemTime.get(item);
                }
            }
            Log.d("MAMA", "MaxTime of all Items "+maxTimeOfAllItems);

            timeOfActivityStarted = Calendar.getInstance().getTime();
            totalTime = maxTimeOfAllItems;
            runningTime = totalTime - (timeOfActivityStarted.getTime() - TimeManagement.getTimeOfOrdering().getTime())/1000;
            Log.d("MAMA", "onCreate: Times "+ totalTime +" and "+ runningTime);
            startStopWatch();


        }
        else
        {
            setContentView(R.layout.activity_c2_2);

        }

    }
    public void startStopWatch(){
        final Handler handler = new Handler();
        handler.post(new Runnable() {
            @Override
            public void run() {
                tv2.setText(String.valueOf(runningTime)+" Seconds");
                if(runningTime >0){
                    if(runningTime <=(2* totalTime)/3){
                        cb1.setChecked(true);
                    }
                    if(runningTime <=(totalTime)/3){
                        cb2.setChecked(true);
                    }
                    if(runningTime ==1){
                        cb3.setChecked(true);
                    }
                    runningTime--;
                    handler.postDelayed(this,1000);
                }else{

                }
            }
        });
    }


}
