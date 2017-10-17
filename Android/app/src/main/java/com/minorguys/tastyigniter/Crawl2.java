package com.minorguys.tastyigniter;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.util.ArrayList;

public class Crawl2 extends AppCompatActivity {
    String names = "";
  String n[]=new String[20];
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_crawl2);
        Intent in = getIntent();
        ArrayList<String[]> list = (ArrayList<String[]>) in.getSerializableExtra("Archit");
        /*TextView t1 = (TextView) findViewById(R.id.t1);
        TextView t2 = (TextView) findViewById(R.id.t2);
        TextView t3 = (TextView) findViewById(R.id.t3);
        TextView t4 = (TextView) findViewById(R.id.t4);
        TextView t5 = (TextView) findViewById(R.id.t5);
        TextView t6 = (TextView) findViewById(R.id.t6);
        TextView t7 = (TextView) findViewById(R.id.t7);
        TextView t8 = (TextView) findViewById(R.id.t8);
        TextView t9 = (TextView) findViewById(R.id.t9);
        TextView t10 = (TextView) findViewById(R.id.t10);
        TextView t11 = (TextView) findViewById(R.id.t11);
        TextView t12 = (TextView) findViewById(R.id.t12);
        TextView t13 = (TextView) findViewById(R.id.t13);
        TextView t14 = (TextView) findViewById(R.id.t14);
        TextView t15 = (TextView) findViewById(R.id.t15);
        TextView t16 = (TextView) findViewById(R.id.t16);
        TextView t17 = (TextView) findViewById(R.id.t17);
        TextView t18 = (TextView) findViewById(R.id.t18);
        TextView t19 = (TextView) findViewById(R.id.t19);
        TextView t20 = (TextView) findViewById(R.id.t20);*/
        final LinearLayout lm = (LinearLayout) findViewById(R.id.linearmain);
        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT);
        for(int j=0;j<=19;j++)
        {
            LinearLayout ll = new LinearLayout(this);
            ll.setOrientation(LinearLayout.HORIZONTAL);


            n=list.toArray(new String[list.size()]);



            EditText h = new EditText(this);
            h.setText(n[j].toString().substring(n[j].indexOf('>')+1,n[j].lastIndexOf('<')));
            h.setBackground(getResources().getDrawable(R.drawable.shape));
            h.setEnabled(false);
            h.setFocusable(false);
            params.setMargins(5, 5, 5, 5);
            h.setLayoutParams(params);
            ll.addView(h);
            lm.addView(ll);
        }



        }
    }
