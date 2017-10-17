package com.minorguys.tastyigniter;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.widget.EditText;
import android.widget.LinearLayout;
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
import com.minorguys.tastyigniter.testing.*;

import org.json.JSONObject;

import java.util.Set;

public class check extends AppCompatActivity {
    int iid;
    double total=0;
    double latest=0;
int p=1;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_check);
final TextView tot=(TextView)findViewById(R.id.text) ;
        tot.setText("Amount of your order is "+total+" ");
        //final LinearLayout lm = (LinearLayout) findViewById(R.id.linearmain);
        TextView q = new TextView(this);
        q.setTextSize(20.0f);
        q.setText("Quantity           ");
        final TextView tt=new TextView(this);
        tt.setTextSize(20.0f);
        tt.setText(" Item Name         ");
        final TextView tt1=new TextView(this);
        tt1.setTextSize(20.0f);
        tt1.setText("Price            ");

        TableLayout ll =(TableLayout)findViewById(R.id.displayLinear);
        TableRow row=new TableRow(this);
      //  ll.setOrientation(TableLayout.HORIZONTAL);
        row.addView(tt);
        row.addView(q);
        row.addView(tt1);
       ll.addView(row,0);
        Set<String> keys = Cart.samaan.keySet();
        for(String i: keys)
        {

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


            StringRequest stringRequest = new StringRequest(Request.Method.GET,"http://u1701227.nettech.firm.in/api/display.php".concat("?item_id="+i),
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {

                            try {
                                JSONObject x = new JSONObject(response);
                                String message=x.getString("message");
                                if(message.equals("SUCCESS"))
                                {
                                   tt2.setText(x.getString("menu_name"));
                                    tt21.setText(x.getString("menu_price"));
                                    double a=Double.parseDouble(tt21.getText().toString());
                                    double b=Double.parseDouble(q1.getText().toString());


                                    total=total+a*b;
                                  //  Toast.makeText(check.this, "   "+total, Toast.LENGTH_SHORT).show();
                                   tot.setText("Amount of your order is "+total+" ");

                                }
                                else
                                    Toast.makeText(getApplicationContext(), "Wrong", Toast.LENGTH_LONG).show();

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






    }
}
