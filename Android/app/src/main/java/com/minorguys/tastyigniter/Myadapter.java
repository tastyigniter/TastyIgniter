package com.minorguys.tastyigniter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;

import static java.util.Objects.isNull;

/**
 * Created by hp-u on 25-09-2017.
 */

public class Myadapter extends RecyclerView.Adapter<Myadapter.MyadapterHolder>
{

    public Context context;
    public Mydata data[];
    public Myadapter(Context context, Mydata[] data)
    {
        this.context=context;
        this.data=data;


    }

    @Override
    public MyadapterHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        LayoutInflater inflater=LayoutInflater.from(parent.getContext());
        View view=inflater.inflate(R.layout.itemcard,parent,false);
        return new MyadapterHolder(view);
    }

    @Override
    public void onBindViewHolder(final MyadapterHolder holder, int position)
    {
        final Mydata user=data[position];
        holder.txt1.setText(user.getName());
        holder.txt2.setText(user.getDescription());
        holder.txt3.setText(user.getPrice());
        holder.txt4.setText(user.getQuantity());
        quantityBttnSetter(user,holder);


        try{
            if((Cart.getA(user.getItem_id())==0)){

            }
        }
        catch(Exception e)
        {
            Cart.setIDA(user.getItem_id(),0);
        }


        String imgurl="http://u1701227.nettech.firm.in/"+user.getImage_url();

        Glide.with(holder.imageView.getContext()).load(imgurl).into(holder.imageView);
        holder.btnplus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String iid = user.getItem_id();
                //Toast.makeText(context, Cart.getA(iid)+" "+iid, Toast.LENGTH_SHORT).show();
                int k=Cart.getA(iid);
                if(k==Integer.parseInt(holder.txt4.getText().toString())){
                    Toast.makeText(context, "Amounnt exceeded", Toast.LENGTH_SHORT).show();
                    return;
                }
                Cart.adder(iid);
                quantityBttnSetter(user,holder);


            }
        });
        holder.btnminus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String iid = user.getItem_id();

                int k=Cart.getA(iid);
                if(k==0){
                    Toast.makeText(context, "Amount can't be negative", Toast.LENGTH_SHORT).show();
                    return;
                }
                Cart.sub(iid);
                quantityBttnSetter(user,holder);
            }
        });

    }
    private void quantityBttnSetter(Mydata user,final MyadapterHolder holder){
            holder.tx.setText(Integer.toString((Cart.getA(user.getItem_id()))));

    }

    @Override
    public int getItemCount() {
        return data.length;
    }

    public class MyadapterHolder extends RecyclerView.ViewHolder
    {

        TextView txt1;
        TextView txt2;
        TextView txt3;
        TextView txt4;
        ImageView imageView;
        Button btnplus,btnminus;
        TextView txtamt;
        EditText tx;
        Button btn1;
        public int count1=0;
        public MyadapterHolder(View itemView) {
            super(itemView);
            txt1=(TextView) itemView.findViewById(R.id.cardview_title);
            txt2=(TextView) itemView.findViewById(R.id.cardview_desc);
            txt3=(TextView) itemView.findViewById(R.id.card_viewprice);
            txt4=(TextView) itemView.findViewById(R.id.card_viewq);
            imageView=(ImageView)itemView.findViewById(R.id.imagecard);
            btnplus=(Button)itemView.findViewById(R.id.btnp);
            btnminus=(Button)itemView.findViewById(R.id.btnm);
            txtamt=(TextView)itemView.findViewById(R.id.txtamt);
            tx=(EditText)itemView.findViewById(R.id.editText);




        }
    }





}
