package com.minorguys.tastyigniter;

import android.app.NotificationManager;
import android.content.Context;
import android.content.Intent;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.pdf.PdfDocument;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.app.NotificationCompat;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Calendar;
import java.util.Date;
import java.util.Set;

import static com.minorguys.tastyigniter.R.id.text;

public class check extends AppCompatActivity {
    TextView tot;
    double total=0;
    double latest=0;
    RadioButton r;
    Button complete;
    Button proceedb;
    TextView q;
    TextView tt;
    TextView tt1;
    int z;
    TableLayout ll; TableRow row;
    Order or=new Order();
    int p=1;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_check);
        r=(RadioButton)findViewById(R.id.r);
       proceedb=(Button)findViewById(R.id.proceedb);
        complete=(Button)findViewById(R.id.complete);
        tot=(TextView)findViewById(text) ;
        tot.setText("Amount of your order is "+total+" ");
        //final LinearLayout lm = (LinearLayout) findViewById(R.id.linearmain);
        q = new TextView(this);
        q.setTextSize(20.0f);
        q.setText("Quantity           ");
        tt=new TextView(this);
        tt.setTextSize(20.0f);
        tt.setText(" Item Name         ");
        tt1=new TextView(this);
        tt1.setTextSize(20.0f);
        tt1.setText("Price            ");

        ll =(TableLayout)findViewById(R.id.displayLinear);
        row=new TableRow(this);
      //  ll.setOrientation(TableLayout.HORIZONTAL);
        row.addView(tt);
        row.addView(q);
        row.addView(tt1);
       ll.addView(row,0);
        Set<String> keys = Cart.samaan.keySet();
        int j=0;
        for(String i: keys)
        { String quantity=Cart.samaan.get(i).toString();
         // j++;
           // if (j==2) break;
         TableRow  row1=new TableRow(this);
            TableRow.LayoutParams lp = new TableRow.LayoutParams(TableRow.LayoutParams.WRAP_CONTENT);
            row1.setLayoutParams(lp);
            final TextView q1 = new TextView(this);
             q1.setTextSize(20.0f);
            final TextView tt2 = new TextView(this);
            tt2.setTextSize(20.0f);
         final   TextView tt21 = new TextView(this);
            tt21.setTextSize(20.0f);
            //h.setText(n[j].toString().substring(n[j].indexOf('>')+1,n[j].lastIndexOf('<')));
           // h.setBackground(getResources().getDrawable(R.drawable.shape));
           // h.setEnabled(false);
           // h.setFocusable(false);
            UserData o=new UserData();

          //Toast.makeText(check.this,"http://u1701227.nettech.firm.in/api/display.php".concat("?item_id="+i+"&quantity="+quantity+"&order_id="+or.id+"&customer_id="+o.id), Toast.LENGTH_SHORT).show();

           StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/display.php".concat("?item_id="+i+"&quantity="+quantity+"&order_id="+or.id+"&customer_id="+o.id),
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {

                            try {
                                JSONObject x = new JSONObject(response);
                                //String message=x.getString("message");

                                   tt2.setText(x.getString("menu_name"));
                                    tt21.setText(x.getString("menu_price"));
                                    double a=Double.parseDouble(tt21.getText().toString());
                                    double b=Double.parseDouble(q1.getText().toString());

//                                Toast.makeText(check.this, ""+Order.id, Toast.LENGTH_SHORT).show();
                                    total=total+a*b;
                                  //  Toast.makeText(check.this, "   "+total, Toast.LENGTH_SHORT).show();
                                   tot.setText("Amount of your order is "+total+" ");

                                z=or.id;




                            }
                            catch (Exception e)
                            {
                                Toast.makeText(getApplicationContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }

                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(getApplicationContext(),error.getMessage(),Toast.LENGTH_LONG).show();

                        }
                    }) {

            };
           // Toast.makeText(this, ""+latest, Toast.LENGTH_SHORT).show();
           q1.setText(Cart.samaan.get(i).toString());
            RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
            requestQueue.add(stringRequest);
            row1.addView(tt2);
           row1.addView(q1);
            row1.addView(tt21);
            ll.addView(row1,p);
            p++;







        }


   //    create();






    }
    public  void create(){
        Set<String> keys = Cart.samaan.keySet();
       // int j=0;
        for(String i: keys)
        { String quantity=Cart.samaan.get(i).toString();


            TableRow  row1=new TableRow(this);
            TableRow.LayoutParams lp = new TableRow.LayoutParams(TableRow.LayoutParams.WRAP_CONTENT);
            row1.setLayoutParams(lp);
            final TextView q1 = new TextView(this);
            q1.setTextSize(20.0f);
            final TextView tt2 = new TextView(this);
            tt2.setTextSize(20.0f);
            final   TextView tt21 = new TextView(this);
            tt21.setTextSize(20.0f);
            //h.setText(n[j].toString().substring(n[j].indexOf('>')+1,n[j].lastIndexOf('<')));
            // h.setBackground(getResources().getDrawable(R.drawable.shape));
            // h.setEnabled(false);
            // h.setFocusable(false);
            UserData o=new UserData();

            Toast.makeText(check.this,"http://u1701227.nettech.firm.in/api/display.php".concat("?item_id="+i+"&quantity="+quantity+"&order_id="+z+"&customer_id="+o.id), Toast.LENGTH_SHORT).show();

            StringRequest stringRequest1 = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/display.php".concat("?item_id="+i+"&quantity="+quantity+"&order_id="+z+"&customer_id="+o.id),
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {

                            try {
                                JSONObject x = new JSONObject(response);
                                //String message=x.getString("message");
                                Toast.makeText(check.this, ""+z, Toast.LENGTH_SHORT).show();
                                z=x.getInt("order_id");
                                Toast.makeText(check.this, ""+z, Toast.LENGTH_SHORT).show();
                                tt2.setText(x.getString("menu_name"));
                                tt21.setText(x.getString("menu_price"));
                                double a=Double.parseDouble(tt21.getText().toString());
                                double b=Double.parseDouble(q1.getText().toString());

//                                Toast.makeText(check.this, ""+Order.id, Toast.LENGTH_SHORT).show();
                                total=total+a*b;
                                //  Toast.makeText(check.this, "   "+total, Toast.LENGTH_SHORT).show();
                                tot.setText("Amount of your order is "+total+" ");




                            }
                            catch (Exception e)
                            {
                                Toast.makeText(getApplicationContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }

                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(getApplicationContext(),error.getMessage(),Toast.LENGTH_LONG).show();

                        }
                    }) {

            };
            // Toast.makeText(this, ""+latest, Toast.LENGTH_SHORT).show();
            q1.setText(Cart.samaan.get(i).toString());
            RequestQueue requestQueue1 = Volley.newRequestQueue(getApplicationContext());
            requestQueue1.add(stringRequest1);
            row1.addView(tt2);
            row1.addView(q1);
            row1.addView(tt21);
            ll.addView(row1,p);
            p++;







        }
    }


    public void print(View v)
    {   String data="Arpit";
        String extstoragedir = Environment.getExternalStorageDirectory().toString();
        File fol = new File(extstoragedir, "pdf");
        File folder=new File(fol,"pdf");
        if(!folder.exists()) {
            boolean bool = folder.mkdir();
        }
        try {
            final File file = new File(folder, "sample.pdf");
            file.createNewFile();
            FileOutputStream fOut = new FileOutputStream(file);


            PdfDocument document = new PdfDocument();
            PdfDocument.PageInfo pageInfo = new
                    PdfDocument.PageInfo.Builder(100, 100, 1).create();
            PdfDocument.Page page = document.startPage(pageInfo);
            Canvas canvas = page.getCanvas();
            Paint paint = new Paint();

            canvas.drawText(data, 10, 10, paint);



            document.finishPage(page);
            document.writeTo(fOut);
            document.close();

        }catch (IOException e){
            Log.i("error",e.getLocalizedMessage());
        }
    }
    public void go(View v)
    {
     r.setVisibility(View.VISIBLE);
    }
    public void order(View v)
    {
        complete.setVisibility(View.VISIBLE);
    }
    public void generate(View v)
    {
        r.setVisibility(View.INVISIBLE);
        complete.setVisibility(View.INVISIBLE);
        proceedb.setVisibility(View.INVISIBLE);
        StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/invoice.php?order_id=".concat(Integer.toString(or.id)),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                          try{
                              JSONObject x = new JSONObject(response);
                              String message=x.getString("message");
                              Toast.makeText(check.this, or.id+" ", Toast.LENGTH_SHORT).show();

                              if(message.equals("SUCCESS"))
                              {
                                  browse();
                              }
                          }
                          catch (Exception e){
                              Toast.makeText(check.this, "Galat", Toast.LENGTH_SHORT).show();
                          }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(),error.getMessage(),Toast.LENGTH_LONG).show();

                    }
                }) {

        };
        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        requestQueue.add(stringRequest);
        /* WebView browser = (WebView) findViewById(R.id.webview);
        browser.loadUrl("http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/invoice/view/20702"); */


    }
    public void browse()
    {
        saveTheTimeAndRegisterOrder();
        passTheNotification();
        startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("http://u1701227.nettech.firm.in/TastyIgniter-master/assets/bills/".concat(or.id+"")+".pdf")));
        if(clearCache())
        {
            Toast.makeText(this, "cleared", Toast.LENGTH_SHORT).show();
        }

    }
    public boolean clearCache() {

        try {
            File[] files = getBaseContext().getCacheDir().listFiles();

            for (File file : files) {

                // delete returns boolean we can use
                if (!file.delete()) {
                    return false;
                }
            }

            // if for completes all
            return true;

        } catch (Exception e) {}

        // try stops clearing cache
        return false;
    }
    public void passTheNotification()
    {
        Uri alarmSound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

        NotificationCompat.Builder mBuilder = (NotificationCompat.Builder) new NotificationCompat.Builder(this)
                .setSmallIcon(R.drawable.pic)
                .setContentTitle("Hello "+UserData.fname)
                .setContentText("Your Order of "+total+"/- is Completed")
                .setSound(alarmSound);

        NotificationManager mNotificationManager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
        mNotificationManager.notify(001, mBuilder.build());

    }
    public void saveTheTimeAndRegisterOrder(){
        Date timeOfOrdering = Calendar.getInstance().getTime();
        TimeManagement.setTimeOfOrdering(timeOfOrdering);
        TimeManagement.setOrderPlaced(true);
    }




}
