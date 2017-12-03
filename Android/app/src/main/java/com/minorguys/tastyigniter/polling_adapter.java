package com.minorguys.tastyigniter;

import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by amazingshuttler on 30/11/17.
 */

public class polling_adapter extends BaseAdapter {

    private Context context;
    private ArrayList<polling_question> questionArrayList;
    private DatabaseReference mDatabase;
    HashMap<Integer,Integer> firebaseHashMap =new HashMap<Integer,Integer>();

    public polling_adapter(Context c, ArrayList<polling_question> questionArrayList) {
        this.context = c;
        this.questionArrayList = questionArrayList;
    }

    @Override
    public int getCount() {
        return questionArrayList.size()+1;
    }

    @Override
    public polling_question getItem(int position) {
        if(position==questionArrayList.size()) return getItem(position-1);
        return questionArrayList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public int getViewTypeCount() {
        return 2;
    }


    @Override
    public View getView(final int position, View convertView, final ViewGroup parent) {

        LayoutInflater li = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        PollingViewHolder pollingViewHolder;

        if(position==questionArrayList.size()){
            Log.d("MAMA", "getView: TO Check");
            convertView = li.inflate(R.layout.submit_polling,null);
            final Button button = ((Button)convertView.findViewById(R.id.polling_sub_btn));
            button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    boolean flag=true;

                    for(Integer i=0;i<questionArrayList.size();i++){
                        if(!firebaseHashMap.containsKey(i))
                        {
                            flag=false;
                        }
                    }
                    if(!flag){
                        Toast.makeText(context, "Feedback Form is Incomplete", Toast.LENGTH_SHORT).show();
                    }
                    else
                    {
                        //Database Connectivity Part
                        mDatabase = FirebaseDatabase.getInstance().getReference().child("Polling");
                        for(Integer i=0;i<questionArrayList.size();i++){
                            final DatabaseReference newDatabaseRef = mDatabase.child("Q"+(i+1)).child("Count");
                            Log.d("MAMA3", "DBREF "+newDatabaseRef);
                            final DatabaseReference increaseCounter;
                            int hashMapValue = firebaseHashMap.get(i);

                            if(hashMapValue==1){
                                increaseCounter = newDatabaseRef.child("e");
                            }
                            else if(hashMapValue==2){
                                increaseCounter = newDatabaseRef.child("q");
                            }
                            else if(hashMapValue==3){
                                increaseCounter = newDatabaseRef.child("r");
                            }else
                            {
                                increaseCounter = newDatabaseRef.child("w");
                            }
                            Log.d("MAMA3", "onClick: "+increaseCounter);
                            increaseCounter.addListenerForSingleValueEvent(new ValueEventListener() {
                                @Override
                                public void onDataChange(DataSnapshot dataSnapshot) {
                                    Log.d("MAMA", "Giving: "+dataSnapshot);
                                    int currValue = Integer.parseInt(dataSnapshot.getValue().toString());
                                    currValue++;
                                    Log.d("MAMA", "onDataChange:CurrentValue "+dataSnapshot.toString()+" Current "+currValue);

                                    HashMap<String,Object>hMap = new HashMap<>();
                                    hMap.put(increaseCounter.getKey(),Integer.valueOf(currValue));
                                    newDatabaseRef.updateChildren(hMap);
                                }

                                @Override
                                public void onCancelled(DatabaseError databaseError) {
                                    Log.d("MAMA", "onCancelledDBERROR: "+databaseError);
                                }
                            });
                        }
                        Toast.makeText(context, "Thank You for the Feedback", Toast.LENGTH_SHORT).show();
                        Intent I = new Intent(context,MainActivity.class);
                        (context).startActivity(I,null);


                    }

                }
            });
            return convertView;
        }
        else{





            convertView = li.inflate(R.layout.polling,null);

            pollingViewHolder = new PollingViewHolder();
            pollingViewHolder.textView = (TextView) convertView.findViewById(R.id.radio_tv);
            pollingViewHolder.radioGroup = (RadioGroup) convertView.findViewById(R.id.radio_group);
            pollingViewHolder.rd1 = (RadioButton) convertView.findViewById(R.id.rd1);
            pollingViewHolder.rd2 = (RadioButton) convertView.findViewById(R.id.rd2);
            pollingViewHolder.rd3 = (RadioButton) convertView.findViewById(R.id.rd3);
            pollingViewHolder.rd4 = (RadioButton) convertView.findViewById(R.id.rd4);

            if(position<questionArrayList.size() && firebaseHashMap.containsKey(position)){
                try {
                    Log.d("MAMA", "FirebaseHashMap:CheckMap "+"Keys : "+firebaseHashMap.keySet().toString()+" Values : "+firebaseHashMap.values().toString()+" For Position "+position);

                    if (firebaseHashMap.get(position) == 1) {
                        pollingViewHolder.rd1.setChecked(true);
                    }
                    else if (firebaseHashMap.get(position) == 2) {
                        pollingViewHolder.rd2.setChecked(true);
                    }
                    else if (firebaseHashMap.get(position) == 3) {
                        pollingViewHolder.rd3.setChecked(true);
                    }
                    else if (firebaseHashMap.get(position) == 4) {
                        pollingViewHolder.rd4.setChecked(true);
                    }
                }
                catch (Exception e)
                {
                    e.printStackTrace();
                    Log.d("MAMA", "TryCatchException firebaseHashMap Getter Position-: "+position+" /"+e);
                }
            }

            pollingViewHolder.radioGroup.setOnCheckedChangeListener(new RadioGroup.OnCheckedChangeListener() {


                @Override

                public void onCheckedChanged(RadioGroup group, int checkedId) {
                    RadioButton radioButton = (RadioButton) group.findViewById(checkedId);

                    if(radioButton.getId()== R.id.rd1)
                    {
                        firebaseHashMap.put(position,1);
                    }
                    else if(radioButton.getId()== R.id.rd2)
                    {
                        firebaseHashMap.put(position,2);
                    }
                    else if(radioButton.getId()== R.id.rd3)
                    {
                        firebaseHashMap.put(position,3);

                    }else{
                        firebaseHashMap.put(position,4);
                    }
                    Log.d("MAMA", "FirebaseHashMap:RadioBttn Valueinserted at Position "+position+"-"+firebaseHashMap.values().toString());

                }
            });

            polling_question pq = getItem(position);

            pollingViewHolder.textView.setText(pq.getQuestion());
            pollingViewHolder.rd1.setText(pq.getRd1());
            pollingViewHolder.rd2.setText(pq.getRd2());
            pollingViewHolder.rd3.setText(pq.getRd3());
            pollingViewHolder.rd4.setText(pq.getRd4());

            convertView.setTag(pollingViewHolder);



        }
        return convertView;
    }

    static class PollingViewHolder {
        TextView textView;
        RadioGroup radioGroup;
        RadioButton rd1;
        RadioButton rd2;
        RadioButton rd3;
        RadioButton rd4;
    }

}