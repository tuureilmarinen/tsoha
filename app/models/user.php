<?
require 'app/models/group.php';
class User extends BaseModel{
  // Attribuutit
	public $id, $name, $password_digest;
	//private $salt = "aRrRgSWenbw73uk7u+^*rvxrKqL@hU+Shu_Tyh2CkCqGmGBN2+X=zRXZ_^g9C8_y3=5C7JW$b_B!+puvT6JwYxT6D7gfdQRBa+-NEU$5@MUs^M!FgY74?T2s@Z^?hk93dbGp4+$G=abQEPfkRAzBJgy8NsWUAtrjKAE*p$C3!?Rf*zSfpUxsk+p?zwLC%@-StPF^EdhWPB&nXHFsWZM4BpB9CMAP@=mz7H9tsy##F?E#9wWcMKj8w=g=GPx=KSkH5xm@htNQQdPE!5fs-*TUN+3W3Es!z*nb^sTDTH-j$Mpe7Z5NF?^DvE$?z_?^GNYB5_6tj?GPhYFV?YNM-qKJ4w?7k4Sp*pHTBc*we6qxM4UH2+f7&uyT3x?J!Js8QmwGhXFF@+GNuxP#ML_H+66QVLsMf5!UUq2wySQ5bLdyQrbGx%p4EFF?Lg=MAnshWU=G3Ysm_jLzYPVedLT-TL+yHPBEJmX36PyZg&C+dT!ZN=U3X&fN7vNGzYYc67yNgV7ghUtXp4gesry9=6PZ7dH%UA?4C_smM!SfHgsVUS@aekMY_SD&Zt@!NpBF!jE%PLGWkrZcX#JT3LwB$qq6+2htGTW83Ls_T45=tKr&ZHrvQz^Xq$SGABDhNd!8=yfSJ@jfVue5EPX-JVHySBC!+m@a2VqC#anq_!spmx#kFS5x2dSQVWcwsg$?Y6QJ$L4q_m6XbHD-?84Rd_d&YDAXZWSLEzXqt?D^QH85zZh*%2xnx*ycUbvwWz@a6$@Cr752DEqwdAw&@s-^*%&A^-kQ*XqwBgRtpYynY4U$bU!&LZEU#B7hs=dKHnkC88KGzpW?#vy+EvnK=s8a+EBJF_Q2L-*W+2cqDzV5=ASMt3QV_PFCf7wD-qQPY^WdR&3=4Rse_Br=AqBM&ZAqr9T8*U?GRLA2#Kq^%W+xg8Ry&Fx+!!w#2-pjUjFPjmk!rBmVb&G6%5tAVE2xj&?wy9dGNLx7CN%7Tz$pPK@*PnbEZfm2Z+&xZ!vV^?8Nzxgq6RyZd9?gq6F3Na82u%9cXea3?b4$FTASPpaSJ%2WWs6MVMNdFxg$2TwxS%k%dUn2UDUa@97&Mvn@#k&U@ptcMWmz+9+FSXPdR%cwq94T2%bR7y@PT%Hd9c+g$v5_GDK6qH6Q8b_WcTHT!dY3-AN7M+WLP6G&Ux=Xq^t#cbg!gL@t=_svGR$fmgQkK#uuQtG*M!K#q=pc_D*%gw#eB5Q-bk2&=_75DVF4YfP3wDWeN4Z&MxWF6%U2ss$yS7qUNxX&&c^q_ZqQ9%7Kf+gc!LJ8@caMuXBadM$YvAYvHt7nsD7C?BVAFMUvJB2T&FDF@E%4J!j!CuS#Bw&@!MVYUB^9zBGSx-Zzedtca4arE?Pu^=sNc5!gs8+z+7AaC^y#PCb7eEH^a57CwsB@55jsZHqbSZSScKyFx#FYAKCFjHNtfse#^K4DZ@xC7_ZVyGPYREp^Me+m38Nvnhp2w#p?_&9_yxmvG5B=MsQCVELR%8v+_N=A@*=_E#gXebB%gt7drLCx9WtD_NP9XuSr2Mhma^ER*WVWe+QK-WRB^*KYGhadbhzjBeQ3Z6%%8JR2=C$XH63gkTS9n=C6qaJtqMj_!3fCtx2gs3=P_qhaWcbf+fM!rE4wcVv?C#6Y^3BA2FpG@S969p5qxh=a-*@@aU8ed$2z4t4f&VBmB*eX$72rM_Rvse@2u#%G%d@GPfq-*3jsf%fF^TZZaA3vM32Tn%Dk8kCEc-e5P?8U74%k8eFhQ=znvkVUU6M%*Jj*paucPRCEYdBQ9e&HMyD3m!ydPXC4JH$rjLPUna8c=-?MHa$ny=7L_tGw&KtLQx34Ah#NdEFQbCeZjj6vCsfRFj8XSa3!4=-3h+!tmz$kJbnXRd87@ndpD353^nA-gnFydH8en%*g8a9bNXhxS^$&qF%2CSBHKp!$kg!$f6%77fn_NgS^Gd=6Z4!r%x7T=pVy!W_%+ad_&mWgkjJUxwafSBKqJ=UJSCXpDkka9TMW_8!htZRfEHrawQAkF!NVKj6CWaUtBLfDBvRFX3M@&-X266mM";
	// Konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
	}
	public static authenticate($user,$password){
		$query=DB::connection()->prepare('SELECT users.* from users where username=:username and password_digest=:password_digest;');
		$password_digest = password_hash($password);
		$query->execute(array("username" => $user, "password_digest",));
		if($row=$query->fetch()){
			return new User($row);
		} else {
			return null;
		}
	}