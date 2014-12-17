<script type="text/javascript">
$(function () {
	var options = {
		chart: {
			renderTo: 'allChart',
			width: 1100,
			height: 1000,
			zoomType: 'x'
		},
		credits: {
			enabled: false
		},
		title: {
			text: 'Tweet dispersion speed and life cycle'
		},

		legend: {
			enabled: true,
			floating:true,
			align: 'center',
			y: 475,
			layout: "horizontal",
			verticalAlign: "top"
		},
		rangeSelector : {
			buttons : [{
				type : 'day',
				count : 1,
				text : '1D'
			}, {
				type : 'week',
				count : 1,
				text : '1W'
			}, {
				type : 'month',
				count : 1,
				text : '1M'
			}, {
				type : 'all',
				count : 1,
				text : 'All'
			}],
			selected : 3,
			inputEnabled : true,
			inputDateFormat: '%d-%m-%Y'
		},

		yAxis: [{
			floor: 0,
			labels: {
				align: 'right',
				x: -3
			},
			title: {
				text: 'Number of activity'
			},
			height: '45%',
			lineWidth: 2,
			opposite: false,
			offset: 0

		}, {
			floor: 0,
			labels: {
				align: 'right',
				x: -3
			},
			title: {
				text: 'Number of activity'
			},
			top: '55%',
			height: '45%',
			lineWidth: 2,
			opposite: false,
			offset: 0
		}],
		xAxis: [{
			type: 'datetime',
			minRange: 36000000,
			events:{
				afterSetExtremes:function(){
					console.log(this);
					var min = this.min,
					max = this.max,
					chart = this.chart;
					chart.xAxis[1].setExtremes(min,max);

				}
			},
		},{
			offset: -443,
			type: 'datetime',
			minRange: 36000000,
		}],
		series:  [
		{
			type: 'line',
			name: 'All activities',
			"data":[ 5758, 8853, 3999, 10944, 10265, 11281, 8007, 11374, 6696, 10328, 10593, 5687, 12190, 8634, 5614, 5749, 8852, 14958, 10394, 11202, 14565, 6679, 9666, 7405, 7455, 5522, 6525, 5051, 4975, 7246, 12257, 12407, 8433, 3521, 3044, 15229, 11219, 2663, 6202, 6909, 2465, 11852, 8096, 3799, 8360, 4809, 4176, 4876, 11378, 2704, 4125, 10944, 6672, 12657, 9587, 11441, 8312, 6304, 11363, 10397, 8003, 13254, 7752, 6634, 8000, 12168, 4334, 5371, 12080, 11525, 9269, 3979, 13390, 11011, 15102, 9335, 11299, 11835, 8072, 4313, 8674, 8377, 12638, 4563, 15985, 12571, 5103, 11346, 8813, 9559, 10106, 13063, 10566, 8544, 9936, 9611, 11876, 10828, 13363, 8242, 10919, 6210, 6183, 6752, 7563, 2279, 8217, 7807, 13407, 10157, 2777, 4848, 4729, 10802, 12087, 9139, 11189, 4636, 11668, 3279, 14966, 15141, 6260, 11344, 10333, 8813, 10796, 8126, 10185, 3666, 6405, 6842, 12236, 7533, 11657, 3522, 11637, 5341, 12681, 10537, 13847, 6446, 8421, 10699, 12193, 12931, 12456, 7715, 10367, 8172, 8929, 14868, 8545, 4348, 9107, 4620, 12006, 2663, 4537, 5743, 14443, 6640, 5206, 2604, 11764, 8009, 8425, 1796, 6201, 10990, 12818, 2527, 9263, 3468, 7861, 1771, 8602, 3101, 3087, 6319, 5114, 5394, 12062, 1643, 12864, 14238, 5192, 5927, 11277, 10132, 14689, 6361, 8231, 6302, 6982, 9586, 3303, 6078, 9362, 5260, 16388, 11912, 5444, 7075, 11589, 6677, 8865, 8331, 2466, 7255, 9873, 4935, 4747, 11726, 9646, 5191, 8792, 12405, 10321, 9308, 9706, 14406, 6442, 6610, 8662, 9542, 6664, 3157, 10683, 6580, 7464, 7790, 9386, 10910, 7938, 5239, 9394, 8575, 7609, 11458, 4774, 4590, 5854, 7930, 4023, 11194, 6502, 10550, 9433, 6226, 10211, 5866, 4883, 11734, 10112, 7018, 10575, 6734, 9257, 9492, 10350, 5879, 9468, 6936, 6049, 11084, 7991, 9509, 10185, 10190, 14224, 5592, 1536, 5106, 1621, 13021, 8958, 5762, 6550, 10846, 7857, 11247, 7040, 6600, 5243, 9125, 10257, 9353, 10566, 8160, 9903, 11131, 7337, 5182, 13789, 8050, 6954, 8250, 6204, 3843, 12208, 12778, 4143, 11263, 4383, 9928, 9299, 13998, 3559, 7261, 14128, 11240, 8526, 9729, 7772, 10306, 9871, 5706, 5980, 6374, 1668, 9882, 7849, 11894, 9087, 7454, 11743, 5783, 11026, 4391, 11256, 6382, 890, 2665, 12434, 4589, 1071, 12283, 7168, 10810, 10651, 10405, 7684, 9153, 7656, 7301, 9975, 9544, 2609, 4108, 11411, 12744, 9833, 5761, 12941, 8277, 2257, 4372, 9894, 8873] ,
			
			"xAxis": 0, 
			"yAxis": 0,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		}, 
		{
			type: 'line',
			name: 'Web',
			"data":[ 3323, 6680, 385, 8281, 219, 4830, 5584, 1154, 2799, 199, 6774, 550, 1499, 1920, 1883, 3231, 1008, 7893, 179, 6858, 4384, 1012, 7098, 3465, 3243, 1812, 5896, 2936, 4044, 3602, 8304, 6545, 2851, 2193, 1810, 576, 4342, 1463, 3452, 3298, 2188, 7314, 6555, 947, 1248, 469, 1448, 1888, 10582, 2285, 1701, 3131, 3442, 11022, 1162, 3142, 2573, 3087, 6423, 1143, 7864, 12849, 3266, 1416, 2585, 2245, 3384, 1151, 5614, 2445, 8133, 3031, 5548, 5798, 582, 2425, 10211, 5861, 4177, 1449, 6028, 4238, 710, 1288, 9562, 4601, 4046, 11084, 4583, 5193, 3371, 2245, 1071, 6118, 5209, 7556, 373, 7426, 1043, 1106, 6069, 5643, 193, 5254, 2083, 2094, 1601, 1136, 6605, 3538, 1599, 3098, 2649, 9446, 641, 1823, 617, 1416, 8287, 597, 13646, 13869, 702, 1270, 187, 1911, 5598, 6708, 5381, 2186, 825, 6561, 4373, 5966, 8290, 2917, 2161, 530, 3279, 3801, 13266, 4355, 1752, 3040, 5280, 5812, 11447, 243, 1050, 6156, 2787, 7052, 7041, 3616, 2747, 345, 3226, 1973, 1954, 4113, 7463, 4970, 5018, 1451, 2969, 4655, 1104, 469, 3240, 7637, 10332, 519, 3133, 1949, 6320, 139, 5251, 2380, 118, 1648, 4951, 2297, 5750, 198, 1881, 4125, 3525, 767, 8075, 7290, 7259, 3181, 2239, 4801, 6469, 2779, 886, 1299, 6709, 1932, 14234, 84, 3327, 431, 5334, 6105, 5122, 4638, 2295, 6274, 4502, 2316, 205, 9429, 2218, 2959, 1930, 3078, 3052, 1415, 1621, 12037, 4726, 511, 7747, 3078, 333, 2426, 3576, 4655, 396, 964, 7877, 872, 5878, 4220, 8958, 1110, 2122, 10955, 4609, 2036, 3939, 7694, 3463, 1196, 1693, 2023, 6825, 1805, 6473, 4365, 2848, 7385, 2171, 2233, 8360, 5938, 1288, 7324, 1260, 3972, 7880, 528, 1693, 2110, 538, 4243, 5873, 9304, 5634, 5214, 1443, 2913, 1496, 12605, 6351, 2465, 3966, 5431, 1722, 4001, 5443, 1115, 2944, 1169, 2074, 8033, 2236, 2014, 8166, 10353, 4174, 236, 8302, 5575, 3614, 4952, 395, 1881, 3425, 2957, 2596, 9789, 3102, 5242, 2004, 2718, 2672, 5029, 3533, 7254, 6049, 8990, 2395, 8660, 8917, 5664, 226, 4882, 875, 4566, 2925, 1918, 8339, 2878, 11370, 649, 5329, 1293, 10952, 260, 376, 1911, 11615, 4401, 752, 5369, 3263, 4449, 8056, 7664, 7543, 5978, 4073, 5662, 5720, 5158, 2187, 2868, 5123, 12483, 2379, 4717, 11895, 8064, 921, 1936, 4377, 4209] ,
			
			"xAxis": 1, 
			"yAxis": 1,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		}, 
		{
			type: 'line',
			name: 'Mobile',
			"data":[ 2435, 2173, 3614, 2663, 10046, 6451, 2423, 10220, 3897, 10129, 3819, 5137, 10691, 6714, 3731, 2518, 7844, 7065, 10215, 4344, 10181, 5667, 2568, 3940, 4212, 3710, 629, 2115, 931, 3644, 3953, 5862, 5582, 1328, 1234, 14653, 6877, 1200, 2750, 3611, 277, 4538, 1541, 2852, 7112, 4340, 2728, 2988, 796, 419, 2424, 7813, 3230, 1635, 8425, 8299, 5739, 3217, 4940, 9254, 139, 405, 4486, 5218, 5415, 9923, 950, 4220, 6466, 9080, 1136, 948, 7842, 5213, 14520, 6910, 1088, 5974, 3895, 2864, 2646, 4139, 11928, 3275, 6423, 7970, 1057, 262, 4230, 4366, 6735, 10818, 9495, 2426, 4727, 2055, 11503, 3402, 12320, 7136, 4850, 567, 5990, 1498, 5480, 185, 6616, 6671, 6802, 6619, 1178, 1750, 2080, 1356, 11446, 7316, 10572, 3220, 3381, 2682, 1320, 1272, 5558, 10074, 10146, 6902, 5198, 1418, 4804, 1480, 5580, 281, 7863, 1567, 3367, 605, 9476, 4811, 9402, 6736, 581, 2091, 6669, 7659, 6913, 7119, 1009, 7472, 9317, 2016, 6142, 7816, 1504, 732, 6360, 4275, 8780, 690, 2583, 1630, 6980, 1670, 188, 1153, 8795, 3354, 7321, 1327, 2961, 3353, 2486, 2008, 6130, 1519, 1541, 1632, 3351, 721, 2969, 4671, 163, 3097, 6312, 1445, 10983, 10113, 1667, 5160, 3202, 2842, 7430, 3180, 5992, 1501, 513, 6807, 2417, 4779, 2653, 3328, 2154, 11828, 2117, 6644, 6255, 572, 3743, 3693, 171, 981, 5371, 2619, 4542, 2297, 7428, 2232, 6862, 9327, 7269, 7893, 8085, 2369, 1716, 6099, 915, 6464, 6331, 731, 7107, 1925, 7068, 6826, 1509, 10038, 2060, 1019, 436, 7465, 5487, 503, 165, 2554, 1915, 236, 560, 9998, 4809, 8527, 2608, 4421, 3738, 1501, 2035, 4349, 7941, 4785, 2215, 796, 7969, 2168, 9090, 1907, 1588, 6408, 4356, 8974, 7453, 5266, 4312, 886, 8590, 378, 93, 2193, 125, 416, 2607, 3297, 2584, 5415, 6135, 7246, 1597, 5485, 2299, 7956, 8183, 1320, 8330, 6146, 1737, 778, 3163, 4946, 5487, 2475, 3340, 3298, 5809, 1962, 8783, 9821, 1547, 1474, 1281, 4686, 7295, 11280, 887, 2232, 10595, 3986, 2477, 739, 5377, 1646, 954, 42, 5754, 1492, 793, 5316, 4924, 9976, 748, 4576, 373, 5134, 5697, 3098, 304, 6122, 514, 754, 819, 188, 319, 6914, 3905, 6361, 2595, 2741, 141, 3175, 3583, 1639, 4255, 4386, 422, 1240, 6288, 261, 7454, 1044, 1046, 213, 1336, 2436, 5517, 4664] ,
			
			"xAxis": 1, 
			"yAxis": 1,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		}, 
		{
			"data":[ 1806, 4500, 2682, 4818, 1656, 3074, 1340, 81, 984, 1251, 926, 4967, 1328, 3307, 913, 3589, 4143, 4290, 223, 3722, 3649, 662, 1311, 4337, 811, 1598, 181, 298, 3441, 1918, 3936, 2887, 4150, 1329, 1130, 3598, 2040, 211, 4863, 108, 1600, 1611, 4541, 1652, 763, 923, 219, 2853, 764, 416, 3488, 4468, 150, 2753, 2729, 2822, 1683, 2725, 4081, 1512, 1182, 4320, 2664, 1745, 1931, 4765, 641, 4886, 1114, 3597, 426, 1331, 2956, 1470, 4153, 4921, 3370, 4056, 802, 3113, 1287, 4074, 3113, 3021, 4648, 4797, 2907, 3850, 1901, 1625, 2201, 3999, 2150, 921, 2271, 4286, 4499, 4056, 3212, 1705, 2922, 1094, 3674, 506, 4055, 368, 3032, 710, 3428, 2744, 1320, 1507, 1781, 312, 4356, 665, 1831, 204, 4582, 475, 4328, 4090, 2245, 2163, 4392, 2223, 1519, 3735, 2869, 1575, 3066, 4097, 3308, 4810, 1112, 1792, 3067, 340, 3335, 4851, 3777, 1075, 297, 1951, 4178, 4888, 2047, 2101, 3681, 2181, 996, 4818, 224, 3304, 2989, 1485, 3908, 1944, 340, 4658, 3134, 2793, 157, 862, 1437, 1354, 653, 792, 4807, 4241, 4044, 838, 2409, 2778, 126, 455, 4802, 23, 353, 3325, 300, 856, 4839, 994, 4754, 3946, 1595, 2402, 4576, 3131, 4366, 1838, 3712, 4145, 3383, 3474, 825, 2787, 1041, 2934, 4993, 4515, 3845, 3897, 1841, 3757, 185, 3477, 72, 981, 2450, 3580, 2206, 3498, 1445, 738, 1397, 4121, 354, 1456, 2059, 3806, 1786, 2093, 2973, 17, 3667, 16, 597, 41, 1698, 3431, 2095, 4627, 1539, 1179, 3896, 172, 4295, 1580, 2020, 2199, 1334, 2858, 1842, 1209, 3129, 2508, 1859, 2947, 4095, 3566, 1452, 4290, 1053, 1249, 1715, 2483, 4478, 3785, 3894, 2164, 734, 225, 280, 1292, 3978, 2913, 503, 1874, 3789, 430, 908, 1704, 754, 3411, 516, 2018, 3899, 1463, 2018, 1117, 893, 348, 4089, 1865, 2484, 4746, 4178, 3762, 65, 3383, 4309, 668, 2588, 2401, 2149, 1462, 1672, 1205, 2246, 2069, 254, 1301, 2166, 3427, 142, 3363, 22, 4233, 4655, 886, 1080, 1494, 780, 3074, 3834, 917, 796, 158, 631, 365, 2802, 2511, 253, 3354, 1501, 906, 1928, 722, 2856, 1363, 273, 940, 1845, 3756, 828, 4743, 666, 1768, 160, 2728, 507, 2054, 2370, 4035, 2866, 1390, 737, 187, 2363, 4805, 743, 3566, 3133, 2298, 421, 1074, 977, 4409],
			"name": "tweets", 
			
			"xAxis": 1, 
			"yAxis": 1,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		},
		{
			"data":[ 2186, 2384, 460, 4216, 8349, 7663, 5760, 9455, 5158, 7643, 9286, 444, 9057, 5150, 3157, 1598, 4615, 9097, 9372, 7071, 9308, 4247, 7500, 1222, 5683, 2044, 4686, 4653, 1425, 3770, 7822, 9234, 4102, 1801, 836, 9717, 8471, 1503, 107, 4846, 573, 9251, 2904, 1861, 7003, 2243, 2737, 927, 8844, 2234, 314, 5923, 5226, 8300, 6792, 6688, 6345, 2337, 5705, 6897, 6641, 7346, 4201, 4068, 4355, 6671, 3425, 111, 9242, 7658, 8435, 1167, 9496, 9475, 9772, 3518, 6590, 6722, 6664, 859, 6745, 2346, 8962, 632, 9496, 7741, 1807, 6442, 5145, 6775, 6317, 7749, 7442, 7457, 7226, 4111, 6845, 6387, 8438, 5044, 6477, 3594, 1333, 5541, 1650, 1795, 5127, 6228, 8364, 6562, 154, 1750, 2756, 9469, 7628, 6873, 8824, 3328, 6672, 1146, 9505, 9588, 3036, 8065, 4331, 5420, 8710, 3727, 5568, 613, 3042, 1627, 8281, 1207, 8991, 418, 8527, 3960, 8437, 4991, 9770, 4147, 6567, 7156, 7311, 7247, 9647, 4956, 4790, 5126, 6319, 8410, 8053, 851, 5051, 3080, 6186, 588, 3366, 688, 9449, 3505, 4729, 739, 8928, 6489, 5798, 283, 411, 4877, 7597, 1415, 6591, 91, 6088, 1281, 3443, 1508, 2387, 2539, 3992, 3090, 5393, 268, 6172, 8559, 1690, 2320, 6221, 5899, 8652, 3561, 4263, 576, 2122, 5375, 1646, 2689, 6519, 472, 9997, 5406, 312, 1756, 9001, 1585, 8458, 4351, 992, 5989, 7333, 467, 1200, 7435, 7935, 3042, 7153, 8233, 8977, 6880, 7576, 8847, 3549, 3079, 5508, 9283, 1569, 1742, 9649, 4922, 4606, 2528, 6181, 6177, 4425, 2806, 4494, 6985, 2107, 9862, 2185, 390, 3710, 4086, 1995, 8657, 2160, 6709, 6564, 2946, 5440, 817, 1619, 7126, 8296, 4003, 8366, 3580, 2982, 5662, 6148, 2553, 8016, 6152, 4720, 8407, 3958, 5512, 7812, 7280, 9797, 4959, 308, 2967, 598, 9526, 8411, 3419, 742, 9085, 5605, 9905, 5371, 6245, 702, 6100, 6873, 3698, 4968, 3610, 8593, 7732, 2478, 2598, 9435, 5076, 4757, 5159, 2893, 2475, 8536, 9049, 1972, 8986, 1624, 4800, 7933, 9469, 3334, 2714, 9398, 8751, 7265, 8077, 5762, 6149, 5195, 4315, 3629, 4798, 1031, 7575, 3203, 7384, 8752, 2574, 9216, 2945, 7922, 2348, 6505, 3819, 289, 958, 8871, 668, 237, 6360, 5784, 7329, 9769, 5889, 6207, 5555, 4350, 2690, 5876, 6279, 1686, 2961, 7506, 6602, 7205, 1316, 9612, 5852, 1240, 3185, 8359, 2977],
			"name": "retweets", 
			"xAxis": 1, 
			"yAxis": 1,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		},
		{
			"data":[ 1766, 1969, 857, 1910, 260, 544, 907, 1838, 554, 1434, 381, 276, 1805, 177, 1544, 562, 94, 1571, 799, 409, 1608, 1770, 855, 1846, 961, 1880, 1658, 100, 109, 1558, 499, 286, 181, 391, 1078, 1914, 708, 949, 1232, 1955, 292, 990, 651, 286, 594, 1643, 1220, 1096, 1770, 54, 323, 553, 1296, 1604, 66, 1931, 284, 1242, 1577, 1988, 180, 1588, 887, 821, 1714, 732, 268, 374, 1724, 270, 408, 1481, 938, 66, 1177, 896, 1339, 1057, 606, 341, 642, 1957, 563, 910, 1841, 33, 389, 1054, 1767, 1159, 1588, 1315, 974, 166, 439, 1214, 532, 385, 1713, 1493, 1520, 1522, 1176, 705, 1858, 116, 58, 869, 1615, 851, 1303, 1591, 192, 1021, 103, 1601, 534, 1104, 414, 1658, 1133, 1463, 979, 1116, 1610, 1170, 567, 664, 1748, 1478, 297, 1118, 647, 1516, 1554, 1312, 43, 1041, 909, 695, 300, 1224, 1557, 1592, 704, 796, 762, 658, 1896, 865, 1614, 1640, 268, 193, 1067, 55, 1912, 131, 831, 397, 1860, 342, 320, 1003, 1399, 166, 1974, 721, 983, 1872, 1177, 274, 263, 599, 1647, 35, 357, 1570, 347, 455, 822, 1448, 1830, 381, 1938, 1733, 1907, 1205, 480, 1102, 1671, 962, 256, 1581, 1477, 737, 832, 602, 1802, 1854, 1398, 1991, 1287, 1422, 747, 1335, 222, 503, 1402, 285, 90, 888, 1341, 793, 266, 1411, 242, 51, 990, 972, 71, 1753, 1107, 1438, 181, 242, 1428, 1399, 437, 1617, 1160, 1831, 1110, 106, 1974, 1254, 1004, 1418, 1207, 16, 569, 2001, 810, 986, 186, 1328, 1213, 1333, 1010, 333, 676, 1483, 1812, 318, 763, 1766, 494, 671, 1797, 45, 308, 1162, 718, 559, 1049, 1385, 55, 1084, 1870, 1036, 638, 203, 320, 435, 269, 84, 31, 325, 1909, 298, 234, 225, 776, 7, 452, 1160, 900, 909, 1420, 788, 1245, 16, 550, 1916, 1766, 573, 48, 1629, 1639, 163, 1426, 1660, 1917, 976, 593, 1701, 1224, 1166, 203, 314, 75, 1603, 181, 158, 1230, 1083, 842, 474, 1555, 1418, 6, 1942, 1844, 1999, 82, 1526, 1026, 1932, 1176, 1321, 1895, 1200, 328, 767, 1718, 165, 6, 1180, 718, 1713, 722, 1788, 970, 1544, 936, 576, 1233, 1875, 186, 960, 1542, 1337, 1885, 879, 196, 127, 596, 113, 558, 1487],
			"name": "replies", 
			"xAxis": 1, 
			"yAxis": 1,
			"pointInterval": 3600 * 1000, 
			"pointStart": Date.UTC(2012, 0, 1)
		}
		]
	};

	var chart = new Highcharts.StockChart(options);
});
</script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>


<div id="page-wrapper">
	<div class="container-fluid col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
		<br>
		<div class="panel panel-green">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Speed and Life Cycle</h3>
			</div>
			<div class="panel-body">
				<div id="allChart" style="margin:0 auto"></div>				
			</div>
		</div>
	</div>
</div>
