package com.waydrow.newloveinn;

import android.app.ProgressDialog;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.design.widget.Snackbar;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.waydrow.newloveinn.adapter.ExchangeAdapter;
import com.waydrow.newloveinn.bean.ExchangeItem;
import com.waydrow.newloveinn.util.API;
import com.waydrow.newloveinn.util.HttpUtil;
import com.waydrow.newloveinn.util.Utility;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.StringTokenizer;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.FormBody;
import okhttp3.RequestBody;
import okhttp3.Response;

public class LoveMoneyActivity extends AppCompatActivity implements AdapterView.OnItemClickListener, ExchangeAdapter.Callback {

    private static final String TAG = "HistoryActivity";
    // 用户 id
    private String userId;
    private ProgressDialog progressDialog;

    private ListView listView;

    private ExchangeAdapter exchangeAdapter;

    private SwipeRefreshLayout swipeRefresh;

    private List<ExchangeItem> exchangeItemList = new ArrayList<>();

    private TextView moneyTextView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_love_money);

        ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
        }

        // 获取用户 id
        SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
        userId = prefs.getString(API.PREF_USER_ID, null);

        moneyTextView = (TextView) findViewById(R.id.money_num_text);
        listView = (ListView) findViewById(R.id.exchange_list_view);
        exchangeAdapter = new ExchangeAdapter(this, exchangeItemList, this);
        swipeRefresh = (SwipeRefreshLayout) findViewById(R.id.swipe_refresh_layout);
        listView.setAdapter(exchangeAdapter);

        queryFromServer();

        // 下拉刷新
        swipeRefresh.setColorSchemeResources(R.color.colorPrimary);
        swipeRefresh.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                queryFromServer();
            }
        });

        listView.setOnItemClickListener(this);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    // 获取礼品兑换信息
    private void queryFromServer() {
        showProgressDialog();

        String aurl = API.INTERFACE + "getMoney";
        RequestBody body = new FormBody.Builder()
                .add("user_id", userId)
                .build();
        HttpUtil.sendPostRequest(aurl, body, new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {

            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String responseText = response.body().string();
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        moneyTextView.setText(responseText);
                    }
                });
            }
        });


        String url = API.INTERFACE + "exchangeInfo";
        HttpUtil.sendGetRequest(url, new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        closeProgressDialog();
                        Toast.makeText(LoveMoneyActivity.this, "加载失败", Toast.LENGTH_SHORT).show();
                    }
                });
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseText = response.body().string();
                exchangeItemList.clear();
                List<ExchangeItem> tmpList = Utility.handleExchangeList(responseText);
                for (ExchangeItem item : tmpList) {
                    exchangeItemList.add(item);
                }
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        closeProgressDialog();
                        if (exchangeItemList == null) {
                            Toast.makeText(LoveMoneyActivity.this, "加载失败", Toast.LENGTH_SHORT).show();
                        } else {
                            exchangeAdapter.notifyDataSetChanged();
                            listView.setSelection(0);
                        }
                        swipeRefresh.setRefreshing(false);
                    }
                });
            }
        });

    }

    // 显示加载框
    private void showProgressDialog() {
        if (progressDialog == null) {
            progressDialog = new ProgressDialog(this);
            progressDialog.setMessage("正在加载...");
            progressDialog.setCanceledOnTouchOutside(false);
        }
        progressDialog.show();
    }

    // 关闭加载框
    private void closeProgressDialog() {
        if (progressDialog != null) {
            progressDialog.dismiss();
        }
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        Toast.makeText(this, position, Toast.LENGTH_SHORT).show();
    }

    @Override
    public void click(final View v) {
        /*Toast.makeText(LoveMoneyActivity.this, "listview的内部的按钮被点击了！，位置是-->" + (Integer) v.getTag() + ",内容是-->"
                        + exchangeItemList.get((Integer) v.getTag()),
                Toast.LENGTH_SHORT).show();*/
        // 获取到点击的位置
        int position = Integer.valueOf(v.getTag().toString());
        ExchangeItem clickItem = exchangeItemList.get(position);
        // 获取点击的礼品 id
        String exid = clickItem.getId();
        // 获取点击的礼品 money
        final int exmoney = Integer.valueOf(clickItem.getExmoney());
        // 当前剩余的爱心币
        final int currentMoney = Integer.valueOf(moneyTextView.getText().toString());
        // 余额不中, 无法兑换
        if (currentMoney < exmoney) {
            Toast.makeText(LoveMoneyActivity.this, "您的爱心币不足, 无法兑换", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = API.INTERFACE + "exchangeApply";
        RequestBody body = new FormBody.Builder()
                .add("user_id", userId)
                .add("ex_id", exid)
                .add("set_money", String.valueOf(currentMoney-exmoney))
                .build();
        HttpUtil.sendPostRequest(url, body, new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        Toast.makeText(LoveMoneyActivity.this, "兑换失败", Toast.LENGTH_SHORT).show();
                    }
                });
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String responseText = response.body().string();
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        if (responseText.equals("0")) {
                            Toast.makeText(LoveMoneyActivity.this, "兑换失败", Toast.LENGTH_SHORT).show();
                        } else if (responseText.equals("1")) {
                            // 更改余额
                            String tmpText = String.valueOf(currentMoney - exmoney);
                            moneyTextView.setText(tmpText);
                            Snackbar.make(v, "兑换成功, 请等待通知", Snackbar.LENGTH_LONG).show();
                        }
                    }
                });
            }
        });
    }
}
