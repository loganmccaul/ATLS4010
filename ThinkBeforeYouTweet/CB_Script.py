from tweepy import Stream
from tweepy import OAuthHandler
from tweepy.streaming import StreamListener
from random import randint
import tweepy, time, sys
import json
import codecs
import MySQLdb
#SQL connection
db = MySQLdb.connect(host="127.0.0.1", user="lomc9041", passwd="Test123!", db="lomc9041db")

cur = db.cursor()
def mysql(t):
	try:
		cur.execute("""INSERT INTO cb (tweet) VALUES (%s)""", t)
		db.commit()
		print "Uploaded Succesfully"
	except:
		db.rollback()


CONSUMER_KEY = 'H2YZfDYj2qrK0PHCSU753FKQg'#keep the quotes, replace this with your consumer key
CONSUMER_SECRET = '1hmzIOpggaTAYtBTCHuHJ9iizcS51eQXkqExEeK7XvESCNIxHj'#keep the quotes, replace this with your consumer secret key
ACCESS_KEY = '2417516252-RQGnbw3NMx4tPdQBo56P4BDHPwWCEFNb0dPZuRL'#keep the quotes, replace this with your access token
ACCESS_SECRET = '5Q2SEi8bQ2lihHwY8vVU8wG3boHdbjFQiWT2r9lVUIEna'#keep the quotes, replace this with your access token secret
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(ACCESS_KEY, ACCESS_SECRET)
api = tweepy.API(auth)
		
hide = ['sissy', 'RT']
search = ['faggot', 'kill', 'die', 'bitch', 'worthless', 'fugly']

class listener(StreamListener):
    
    print "listening..."
    def on_status(self, status):
		t = status.text.encode('utf-8', 'ignore')
		#Hide Tweets containing hidden words
		if 'sissy' not in t and 'RT' not in t:
			#Only show tweets tweeted at people
			if "@" in t:
				#Remove everything, but status		
				t = t.replace('&amp', "&")
				t = t.replace('', '')
				tmp = t.split()
				#remove all of the @
				for i in tmp:
					if "@" in i:
						t = t.replace(i, '')
						
				#kill yourself
				if " kill " in t:
					if " yourself" in t:
						#print tweet without starting space
						print t.lstrip()
						mysql(t.lstrip())
						print '\n'
				#You faggot
				if " faggot" in t:
					if " you" in t:
						print t.lstrip()
						mysql(t.lstrip())
						print'\n'
				#Go Die/ hope you die
				if " die " in t:
					if " go " in t:
						print t.lstrip()
						mysql(t.lstrip())
						print'\n'
					if " hope" in t and "you" in t:
						print t.lstrip()
						mysql(t.lstrip())
						print'\n'
				#You are bitch
				if " bitch " in t or " worthless " in t:
					if " you " in t and " are " in t and " a " in t:
						print t.lstrip()
						mysql(t.lstrip())
						print'\n'
				#Fugly
				if "fugly " in t:
					print t.lstrip()
					mysql(t.lstrip())
					print '\n'
    def on_error(self, status):
        print status

twitterStream = Stream(auth, listener())
twitterStream.filter(track = search)
db.close()
